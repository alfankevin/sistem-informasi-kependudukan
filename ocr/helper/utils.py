import cv2
import numpy as np
import pytesseract
import re
import json
import statistics
from helper import postprocessing as post
from helper import preprocessing as pre
from helper import keywords

def preprocessing(image):
    resized = cv2.resize(image, None, fx=3, fy=3, interpolation=cv2.INTER_LINEAR)
    cv2.imwrite('image.jpg', resized)
    reimage = cv2.imread('image.jpg')

    gray = cv2.cvtColor(reimage, cv2.COLOR_BGR2GRAY)
    thresh = cv2.threshold(gray, 0, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)[1]
    kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (3,3))
    clean = cv2.morphologyEx(thresh, cv2.MORPH_CLOSE, kernel, iterations=1)
    preprocessed_image = cv2.bitwise_not(clean)

    return preprocessed_image

### Process the image
def process_image(preprocessed_image):
    cv2.imwrite("preprocessed.jpg", preprocessed_image)
    image2 = cv2.imread('preprocessed.jpg')

    # Grayscale
    gray = cv2.cvtColor(image2, cv2.COLOR_BGR2GRAY)

    # Binary
    _, binary = cv2.threshold(gray, 128, 255, cv2.THRESH_BINARY_INV)

    # Find contours
    contours, _ = cv2.findContours(binary, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    # Sort contours
    sorted_contours = sorted(contours, key=cv2.contourArea, reverse=True)

    # Find largest contour
    main_box = sorted_contours[:2]

    column_images = []
    # Loop from largest contour
    for i, contour in enumerate(main_box):
        # Bounding box
        x, y, w, h = cv2.boundingRect(contour)

        # Crop image
        cropped_top = image2[0:y, :]
        cropped_box = image2[y:y + h, x:x + w]
        cv2.imwrite('header.jpg', cropped_top)

        # Process box
        valid_columns = pre.column_segmentation(cropped_box)
        column_images.extend(valid_columns)

    header_image = cv2.imread('header.jpg')

    return {
        "header_image": header_image,
        "column_images": column_images,
    }

def extract_image(header_image, column_images):
    data_header = extract_header_image(header_image)
    anggota_keluarga = extract_column_image(column_images)

    # Create the family data structure
    family_data = {
        "nomor_kk": data_header["nomor_kk"],
        "nama_kepala_keluarga": data_header["nama_kepala_keluarga"],
        "kecamatan": data_header["kecamatan"],
        "alamat": data_header["alamat"],
        "kabupaten": data_header["kabupaten"],
        "rt": data_header["rt"],
        "rw": data_header["rw"],
        "kode_pos": data_header["kode_pos"],
        "kelurahan": data_header["kelurahan"],
        "provinsi": data_header["provinsi"],
        "anggota_keluarga": anggota_keluarga
    }

    print(family_data)

    return family_data

def extract_header_image(header_image):
    # OCR on Preprocessed Image
    custom_config = r'--oem 1 --psm 6'
    rawtext = pytesseract.image_to_string(header_image, config=custom_config)
    text = rawtext.replace('\n', ' ')  # Normalize line breaks
    cleaned_text = re.sub(r'[^a-zA-Z0-9 \n]', '', text)
    cleaned_text = re.sub(r"([a-zA-Z])(\d)", r"\1 \2", cleaned_text)
    cleaned_text = re.sub(r'\bRepublik\b', '', cleaned_text, flags=re.IGNORECASE)
    cleaned_text = re.sub(r'\bIndonesia\b', '', cleaned_text, flags=re.IGNORECASE)

    corrected_text = re.sub(r'\bNam\w*\b', 'Nama', cleaned_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bAla\w*\b|\bLamat\w*\b', 'Alamat', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bRT\w*\b|\bRW\w*\b', 'RTRW', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bKod\w*\b|\bOde\w*\b', 'Kode', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bDes\w*\b|\bLurah\w*\b', 'Kelurahan', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bKec\w*\b|\bCamat\w*\b', 'Kecamatan', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bKab\w*\b|\bBupat\w*\b', 'Kabupaten', corrected_text, flags=re.IGNORECASE)
    corrected_text = re.sub(r'\bProv\w*\b|\bVins\w*\b', 'Provinsi', corrected_text, flags=re.IGNORECASE)

    # Daftar kata kunci yang harus diikuti oleh '\n'
    keywords = ["Nama", "Alamat", "RT", "Kode", "Kelurahan", "Kecamatan", "Kabupaten", "Provinsi"]

    # Buat regex untuk mendeteksi kata kunci
    pattern = r'(' + '|'.join(map(re.escape, keywords)) + r')'

    # Tambahkan \n setelah kata kunci yang ditemukan
    formatted_text = re.sub(pattern, r'\n\1', corrected_text)

    extracted_text = get_header_data(formatted_text)

    return extracted_text

def get_header_data(text):
    # Initialize all variables
    nama_kepala_keluarga = ""
    kecamatan = ""
    alamat = ""
    kabupaten = ""
    rt = ""
    rw = ""
    kode_pos = ""
    kelurahan = ""
    provinsi = ""
    nomor_kk = re.findall(r"\b\d{15,}\b", text)
    nomor_kk = nomor_kk[0] if nomor_kk else ""

    current_key = None

    for line in text.split('\n'):
        line = line.strip()
        if not line:
            continue

        words = line.split()
        if not words:
            continue

        # Determine current key by checking partial matches
        if any(word in line for word in ["Nama", "Kepala", "Keluarga"]):
            current_key = "Nama"
        elif "Kecamatan" in line:
            current_key = "Kecamatan"
        elif "Alamat" in line:
            current_key = "Alamat"
        elif "Kabupaten" in line:
            current_key = "Kabupaten"
        elif "RTRW" in line:
            current_key = "RTRW"
        elif "Kode" in line:
            current_key = "Kode Pos"
        elif "Kelurahan" in line:
            current_key = "Kelurahan"
        elif "Provinsi" in line:
            current_key = "Provinsi"
        else:
            current_key = None

        if current_key is None:
            continue

        # Get the value part (everything after the key)
        value_part = line.split(current_key, 1)[-1].strip()
        words = value_part.split()

        # Process based on current_key
        if "Nama" in current_key:
            all_caps = [word for word in words if word.isupper()]
            if all_caps:
                nama_kepala_keluarga = ' '.join(all_caps)
        elif "Kecamatan" in current_key:
            all_caps = [word for word in words if word.isupper()]
            if all_caps:
                kecamatan = ' '.join(all_caps)
        elif "Alamat" in current_key:
            valid_parts = [word for word in words if word.isupper() or word.isdigit()]
            if valid_parts:
                alamat = ' '.join(valid_parts)
        elif "Kabupaten" in current_key:
            all_caps = [word for word in words if word.isupper()]
            if all_caps:
                kabupaten = ' '.join(all_caps)
        elif "RTRW" in current_key:
            numbers = ''.join([word for word in words if word.isdigit()])
            if len(numbers) >= 6:
                rt = numbers[:3]
                rw = numbers[3:6]
        elif "Kode" in current_key:
            numbers = ''.join([word for word in words if word.isdigit()])
            kode_pos = numbers
        elif "Kelurahan" in current_key:
            all_caps = [word for word in words if word.isupper()]
            if all_caps:
                kelurahan = ' '.join(all_caps)
        elif "Provinsi" in current_key:
            all_caps = [word for word in words if word.isupper()]
            if all_caps:
                provinsi = ' '.join(all_caps)

    return {
        "nomor_kk": nomor_kk,
        "nama_kepala_keluarga": nama_kepala_keluarga,
        "kecamatan": kecamatan,
        "alamat": alamat,
        "kabupaten": kabupaten,
        "rt": rt,
        "rw": rw,
        "kode_pos": kode_pos,
        "kelurahan": kelurahan,
        "provinsi": provinsi,
    }


def extract_column_image(column_images):
    # Initialize variables to store extracted data
    nama_lengkap_data = []
    nik_data = []
    jenis_kelamin_data = []
    tempat_lahir_data = []
    tanggal_lahir_data = []
    agama_data = []
    pendidikan_data = []
    jenis_pekerjaan_data = []
    golongan_darah_data = []
    status_perkawinan_data = []
    status_keluarga_data = []

    for i, column_img in enumerate(column_images):
        # Extract text using Tesseract
        text = pytesseract.image_to_string(column_img[:, :, ::-1], config='--oem 1 --psm 11')
        corrected_text = re.sub(r'\bLeng\w*\b', 'Lengkap', text, flags=re.IGNORECASE)

        if re.search(r"Nama\nLengkap|Lengkap", corrected_text, re.IGNORECASE):
            nama_lengkap_data = post.clean_nama_data(corrected_text)
        elif re.search(r'NIK', text, re.IGNORECASE) and re.search(r'\d{10,}', text):
            nik_data = post.clean_nik_data(text)
        elif re.search(r"Jenis\nKelamin|Kelamin|Laki|Perempuan", text, re.IGNORECASE):
            jenis_kelamin_data = post.extract_column(column_img, keywords.jenis_kelamin_keywords)
        elif re.search(r"Tempat\nLahir|Tempat", text, re.IGNORECASE):
            tempat_lahir_data = post.extract_column(column_img, keywords.kota_keywords)
        elif re.search(r'(?<!Kawin)(?:Lahir|ahir|hir)', text, re.IGNORECASE) and re.search(r'\b\d{1,2}[-./]\d{1,2}[-./]\d{2,4}\b', text):
            tanggal_lahir_data = post.clean_tanggal_lahir_data(text)
        elif re.search(r"Agama|Islam|Kristen", text, re.IGNORECASE):
            agama_data = post.extract_column(column_img, keywords.agama_keywords)
        elif re.search(r"Pendidikan|Tamat|Sekolah", text, re.IGNORECASE):
            pendidikan_data = post.extract_column(column_img, keywords.pendidikan_keywords)
        elif re.search(r"Pekerjaan|Guru|Rumah|Karyawan|Swasta", text, re.IGNORECASE):
            jenis_pekerjaan_data = post.extract_column(column_img, keywords.jenis_pekerjaan_keywords)
        elif re.search(r"Golongan|Darah", text, re.IGNORECASE):
            golongan_darah_data = post.extract_column(column_img, keywords.golongan_darah_keywords, "golongan")
        elif re.search(r'(?<!Tanggal)Kawin', text, re.IGNORECASE) and re.search(r"Status", text, re.IGNORECASE):
            status_perkawinan_data = post.extract_column(column_img, keywords.status_perkawinan_keywords, "perkawinan")
        elif re.search(r"Status\nKeluarga|Keluarga|Istri|Isteri|Anak", text, re.IGNORECASE):
            status_keluarga_data = post.extract_column(column_img, keywords.status_keluarga_keywords)

    # Determine the maximum length among all lists
    max_length = max(
        len(nama_lengkap_data),
        len(nik_data),
    )

    jenis_kelamin_data = post.pad_data_with_mode(jenis_kelamin_data, max_length, use_mode=True)
    tempat_lahir_data = post.pad_data_with_mode(tempat_lahir_data, max_length, use_mode=True)
    agama_data = post.pad_data_with_mode(agama_data, max_length, use_mode=True)
    golongan_darah_data = post.pad_data_with_mode(golongan_darah_data, max_length, default_for_null="O", use_mode=False)
    status_perkawinan_data = post.pad_data_with_mode(status_perkawinan_data, max_length, default_for_null="BELUM KAWIN", use_mode=False)
    # status_perkawinan_data = post.pad_data_with_mode(status_perkawinan_data, max_length, use_mode=True)
    status_keluarga_data = post.pad_data_with_mode(status_keluarga_data, max_length, default_for_null="ANAK", use_mode=False)
    # status_keluarga_data = post.pad_data_with_mode(status_keluarga_data, max_length, use_mode=True)

    # Create a list of dictionaries for each person (family members)
    anggota_keluarga = []
    for i in range(max_length):
        anggota = {
            "nama": post.format_proper_case(nama_lengkap_data[i]) if i < len(nama_lengkap_data) else None,
            "nik": nik_data[i] if i < len(nik_data) else None,
            "jenis_kelamin": post.format_proper_case(jenis_kelamin_data[i]) if i < len(jenis_kelamin_data) else None,
            "tempat_lahir": post.format_proper_case(tempat_lahir_data[i]) if i < len(tempat_lahir_data) else None,
            "tanggal_lahir": tanggal_lahir_data[i] if i < len(tanggal_lahir_data) else None,
            "agama": post.format_proper_case(agama_data[i]) if i < len(agama_data) else None,
            "pendidikan": post.format_proper_case(pendidikan_data[i]) if i < len(pendidikan_data) else None,
            "pekerjaan": post.format_proper_case(jenis_pekerjaan_data[i]) if i < len(jenis_pekerjaan_data) else None,
            "golongan_darah": "O",
            "status_perkawinan": post.format_proper_case(status_perkawinan_data[i]) if i < len(status_perkawinan_data) else None,
            "status_keluarga": post.format_proper_case(status_keluarga_data[i]) if i < len(status_keluarga_data) else None
        }
        anggota_keluarga.append(anggota)

    return anggota_keluarga