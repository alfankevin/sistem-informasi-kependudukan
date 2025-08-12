import cv2
import numpy as np
import pytesseract
import re
import json
import statistics
from collections import defaultdict
from Levenshtein import distance as levenshtein_distance
from datetime import datetime
from calendar import monthrange
from collections import Counter

def clean_text(line):
    """Remove symbols and convert to uppercase."""
    return ''.join(c.upper() for c in line if c.isalpha())

def fuzzy_match(word, target, max_typos=1):
    """Check if 'word' matches 'target' within 'max_typos' edits (Levenshtein distance)."""
    # Handle common substitutions (e.g., "1" → "I", "0" → "O")
    common_typos = {
        "1": "I", "0": "O", "3": "E", "4": "A", "5": "S",
        "7": "T", "8": "B", "9": "G", " ": ""
    }

    # Normalize the word (replace common typos)
    normalized_word = "".join(common_typos.get(c.upper(), c.upper()) for c in word)
    normalized_target = "".join(common_typos.get(c.upper(), c.upper()) for c in target)

    # Check exact match after normalization
    if normalized_word == normalized_target:
        return True

    # Fall back to Levenshtein distance
    return levenshtein_distance(normalized_word, normalized_target) <= max_typos

def extract_column(image, keywords, exclude_words=None):
    text = pytesseract.image_to_string(image, config='--oem 3 --psm 11')  # Convert BGR to RGB
    extract_keywords(text, keywords)
    return extract_keywords(text, keywords, exclude_words)

def extract_keywords(text, keywords, exclude_words=None):
    """Extract keywords from text while excluding specific terms.

    Args:
        text: Input text to search (str or list of str)
        keywords: Dictionary of {typo_pattern: correct} mappings (supports "OR" patterns with |)
        exclude_words: String or list of words to exclude from matching
    """
    if isinstance(text, list):
        text = "\n".join(text)

    # Normalize exclude_words to uppercase list
    if exclude_words:
        exclude_words = [exclude_words.upper()] if isinstance(exclude_words, str) else [word.upper() for word in exclude_words]

    cleaned_lines = [clean_text(line) for line in text.splitlines()]
    results = []

    for line in cleaned_lines:
        # Skip lines containing excluded words
        if exclude_words and any(ex_word in line for ex_word in exclude_words):
            continue

        matched = False

        # Check for exact matches
        for typo_pattern, correct in keywords.items():
            # Split pattern into possible variants
            possible_typos = typo_pattern.split("|")

            # Check if any variant matches exactly
            if any(typo in line for typo in possible_typos):
                results.append(correct)
                matched = True
                break

        # Fall back to fuzzy matching if no exact match
        if not matched:
            for typo_pattern, correct in keywords.items():
                possible_typos = typo_pattern.split("|")
                # Check fuzzy match against all variants
                if any(fuzzy_match(line, typo, max_typos=1) for typo in possible_typos):
                    results.append(correct)
                    matched = True
                    break
    return results

def clean_nama_data(text):
    lines = text.splitlines()
    results = []
    for line in lines:
        stripped_line = line.strip()
        words = stripped_line.split()
        current_cleaned = []
        for word in words:
            clean_word = re.sub(r'[^A-Za-z]', '', word)
            if clean_word == '':
                continue
            if clean_word.isalpha() and clean_word.isupper():
                current_cleaned.append(clean_word)

        if current_cleaned:
            cleaned_line = ' '.join(current_cleaned)
            has_single_letter = any(len(word) <= 1 for word in current_cleaned)
            if (not has_single_letter) and (len(current_cleaned) >= 2 or (len(current_cleaned) == 1 and len(current_cleaned[0]) > 5)):
                results.append(cleaned_line)
    return results

def clean_nik_data(text):
    cleaned_niks = [
        re.sub(r'[^\d]', '', x)
        for x in text.splitlines()
        if len(re.sub(r'[^\d]', '', x)) >= 14
    ]

    seen = set()
    return [nik for nik in cleaned_niks if not (nik in seen or seen.add(nik))]

def clean_tanggal_lahir_data(text):
    # Find all potential date patterns (DD-MM-YYYY with possible surrounding characters)
    potential_dates = re.findall(r'[\'"~—]?\s*(\d{1,2}[-./]\d{1,2}[-./]\d{2,4})\s*[\'"~—]?', text)

    cleaned_dates = []
    for date_str in potential_dates:
        try:
            # Standardize separators to hyphens
            std_date = re.sub(r'[-./]', '-', date_str)

            # Split into day, month, year
            day, month, year = map(int, std_date.split('-'))

            # Adjust 2-digit year to 4-digit (e.g., 87 -> 1987)
            if year < 100:
                year += 2000 if year < 50 else 1900  # Assumes 00-49 = 2000s, 50-99 = 1900s

            # Validate and adjust the day if needed
            _, last_day = monthrange(year, month)  # Get last valid day for the month
            if day > last_day:
                day = last_day  # Reduce day to last valid day

            # Reconstruct the date
            adjusted_date = f"{year}-{month:02d}-{day:02d}"

            # Parse to validate (raises ValueError if still invalid)
            datetime.strptime(adjusted_date, '%Y-%m-%d')

            cleaned_dates.append(adjusted_date)
        except (ValueError, IndexError):
            # Skip if adjustment fails (e.g., month > 12)
            continue

    return cleaned_dates


def fill_missing_with_mode(data_list):
    """Mengisi data kosong dengan nilai yang paling sering muncul (mode)"""
    if not data_list:
        return None
    
    clean_data = [item for item in data_list if item is not None]
    if not clean_data:
        return None
    
    try:
        return statistics.mode(clean_data)
    except statistics.StatisticsError:  # Jika ada beberapa mode dengan frekuensi sama
        return Counter(clean_data).most_common(1)[0][0]

def pad_data_with_mode(data_list, max_length, default_for_null=None, use_mode=True):
    """Mengisi data yang kurang hingga mencapai max_length"""
    if len(data_list) >= max_length:
        return data_list
    
    if use_mode:
        fill_value = fill_missing_with_mode(data_list)
    else:
        fill_value = default_for_null  # Untuk golongan_darah, gunakan "O"
    
    return data_list + [fill_value] * (max_length - len(data_list))

# Fungsi untuk membersihkan nama
def format_proper_case(text):
    if text is None:
        return None
    return text.title()