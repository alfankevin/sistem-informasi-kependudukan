import re
import cv2
import numpy as np
import pytesseract

def preprocessing(image):
    cropped_image = crop_largest_contour(image)
    top1, box1, box2 = process_cropped_image(cropped_image)
    preprocessed_image = preprocess_image(top1)
    cv2.imwrite('top_1.jpg', preprocessed_image)

    return preprocessed_image

def crop_largest_contour(image):
    # Grayscale
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Binary thresholding
    _, binary = cv2.threshold(gray, 128, 255, cv2.THRESH_BINARY_INV)

    # Morphological operation
    kernel = np.ones((5, 5), np.uint8)
    morphed = cv2.morphologyEx(binary, cv2.MORPH_CLOSE, kernel)

    # Find contours
    contours, _ = cv2.findContours(morphed, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    if contours:
        # Find the largest contour
        largest_contour = max(contours, key=cv2.contourArea)

        # Bounding box
        x, y, w, h = cv2.boundingRect(largest_contour)

        # Crop image
        return image[:y + h, x:x + w]
    
    # Return original image if no contours are found
    return image

def process_cropped_image(cropped_image):
    # Grayscale
    gray = cv2.cvtColor(cropped_image, cv2.COLOR_BGR2GRAY)

    # Binary thresholding
    _, binary = cv2.threshold(gray, 128, 255, cv2.THRESH_BINARY_INV)

    # Find contours
    contours, _ = cv2.findContours(binary, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    # Sort contours by area (largest first)
    sorted_contours = sorted(contours, key=cv2.contourArea, reverse=True)

    # Get the top 2 largest contours
    main_box = sorted_contours[:2]

    # Loop through the largest contours
    for i, contour in enumerate(main_box):
        # Bounding box
        x, y, w, h = cv2.boundingRect(contour)

        # Crop image
        cropped_top = cropped_image[0:y, :]
        cropped_box = cropped_image[y:y + h, x:x + w]

        # Save cropped image
        cv2.imwrite(f'top_1.jpg', cropped_top)
        cv2.imwrite(f'box_{i + 1}.jpg', cropped_box)

    # Load the saved images
    top1 = cv2.imread('top_1.jpg')
    box1 = cv2.imread('box_2.jpg')
    box2 = cv2.imread('box_1.jpg')

    return top1, box1, box2

def preprocess_image(image):
    # Grayscale
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Resizing
    resized = cv2.resize(gray, None, fx=2, fy=2, interpolation=cv2.INTER_LINEAR)

    # Denoising
    blurred = cv2.GaussianBlur(resized, (5, 5), 0)

    # Thresholding
    _, thresh = cv2.threshold(blurred, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)

    # Morphology
    kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (3, 3))
    morphed = cv2.morphologyEx(thresh, cv2.MORPH_CLOSE, kernel)

    return morphed

def formatted_text(text):
    # List of keywords that should be followed by '\n'
    keywords = ["No", "Nama", "Alamat", "RT", "Kode", "Desa", "Kec", "Kab", "Prov"]

    # Create regex to detect keywords
    pattern = r'(' + '|'.join(map(re.escape, keywords)) + r')'

    # Add \n after detected keywords
    formatted_text = re.sub(pattern, r'\n\1', text)

    return formatted_text

def final_text(text):
    # Pisahkan teks menjadi baris-baris
    lines = text.strip().split('\n')

    # Inisialisasi variabel
    extracted_data = {
        'nomor_kk': None,
        'kepala_keluarga': None,
        'alamat': None,
        'rt_rw': None,
        'kode_pos': None,
        'kelurahan': None,
        'kecamatan': None,
        'kabupaten': None,
        'provinsi': None
    }

    # Proses setiap baris
    for line in lines:
        # Case-sensitive check for "Nama Kepala Keluarga"
        if "Nama" in line:
            try:
                extracted_data['kepala_keluarga'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Nama Kepala Keluarga' information.")
            continue  # Skip to the next line after processing this one

        # Case-insensitive checks for other keywords
        line_lower = line.lower()  # Convert line to lowercase for case-insensitive matching
        if "no" in line_lower:
            try:
                extracted_data['nomor_kk'] = line.split(".")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'No' information.")
        elif "alamat" in line_lower:
            try:
                extracted_data['alamat'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Alamat' information.")
        elif "rt" in line_lower:
            try:
                extracted_data['rt_rw'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'RT/RW' information.")
        elif "kode" in line_lower:
            try:
                extracted_data['kode_pos'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Kode Pos' information.")
        elif "desa" in line_lower:
            try:
                extracted_data['kelurahan'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Desa/Kelurahan' information.")
        elif "kecamatan" in line_lower:
            try:
                extracted_data['kecamatan'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Kecamatan' information.")
        elif "kabupaten" in line_lower:
            try:
                extracted_data['kabupaten'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Kabupaten/Kota' information.")
        elif "provinsi" in line_lower:
            try:
                extracted_data['provinsi'] = line.split(":")[1].strip()
            except IndexError:
                print("Error: Unable to extract 'Provinsi' information.")

    # Return the extracted data
    return extracted_data
