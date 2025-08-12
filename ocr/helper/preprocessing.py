import cv2
import numpy as np
import pytesseract

def grayscale(image):
    return cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

def noise_removal(image):
    kernel = np.ones((1, 1), np.uint8)
    image = cv2.dilate(image, kernel, iterations=1)
    kernel = np.ones((1, 1), np.uint8)
    image = cv2.erode(image, kernel, iterations=1)
    image = cv2.morphologyEx(image, cv2.MORPH_CLOSE, kernel)
    image = cv2.medianBlur(image, 3)
    return (image)

def erosion(image):
    image = cv2.bitwise_not(image)
    kernel = np.ones((1, 1),np.uint8)
    image = cv2.erode(image, kernel, iterations=1)
    image = cv2.bitwise_not(image)
    return (image)

### Segmentation Functions ###
def apply_thresholding(gray_image):
    """Apply thresholding to get binary image"""
    _, thresh = cv2.threshold(gray_image, 150, 255, cv2.THRESH_BINARY_INV)
    return thresh

def detect_lines(thresh_image):
    """Detect lines using Hough Line Transform"""
    return cv2.HoughLinesP(
        thresh_image,
        1,               # Resolusi rho (1 pixel)
        np.pi / 180,     # Resolusi theta (1 derajat)
        threshold=100,   # Threshold untuk deteksi garis
        minLineLength=50, # Panjang minimal garis
        maxLineGap=10     # Jarak maksimal antara garis yang terputus
    )

def filter_vertical_lines(lines, min_line_length=100):
    """Filter vertical lines from detected lines"""
    vertical_lines = []
    for line in lines:
        x1, y1, x2, y2 = line[0]
        length = np.sqrt((x2 - x1)**2 + (y2 - y1)**2)
        angle = np.arctan2(y2 - y1, x2 - x1) * 180 / np.pi
        if abs(angle) > 80 and abs(angle) < 100 and length >= min_line_length:
            vertical_lines.append((x1, y1, x2, y2))
    return vertical_lines

def remove_duplicate_lines(vertical_lines):
    """Remove duplicate vertical lines"""
    unique_vertical_lines = []
    seen_x = set()
    for line in vertical_lines:
        x1, y1, x2, y2 = line
        if x1 not in seen_x:
            unique_vertical_lines.append(line)
            seen_x.add(x1)
    return sorted(unique_vertical_lines, key=lambda x: x[0])


def column_segmentation(image):
    """Segment image into columns and return column images"""
    # 1. Convert to grayscale
    gray = grayscale(image)

    # 2. Thresholding to get binary image
    thresh = apply_thresholding(gray)

    # 3. Detect lines
    lines = detect_lines(thresh)
    if lines is None:
        return []  # No lines detected

    # 4. Filter vertical lines
    vertical_lines = filter_vertical_lines(lines)

    # 5. Remove duplicate lines
    vertical_lines_sorted = remove_duplicate_lines(vertical_lines)

    # 6. Extract column images
    min_column_width = 50
    valid_columns = []
    for i in range(len(vertical_lines_sorted) - 1):
        x1 = vertical_lines_sorted[i][0]
        x2 = vertical_lines_sorted[i + 1][0]
        if x2 - x1 >= min_column_width:
            column_img = image[:, x1:x2]
            # display(column_img, 4)
            valid_columns.append(column_img)

    return valid_columns