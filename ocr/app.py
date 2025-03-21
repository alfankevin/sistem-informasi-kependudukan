from flask import Flask, request, jsonify
from PIL import Image
from helper import utils
import pytesseract
import numpy as np
import cv2
import os
import re

app = Flask(__name__)

@app.route('/ocr', methods=['POST'])
def ocr():
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    
    file = request.files['file']
    
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400
    
    # Simpan file sementara
    file_path = os.path.join('/tmp', file.filename)
    file.save(file_path)
    
    # Baca gambar dengan OpenCV
    image = cv2.imread(file_path)

    # Preprocess the image
    preprocessed_image = utils.preprocessing(image)

    # Run OCR
    custom_config = r'--oem 3 --psm 6'
    text = pytesseract.image_to_string(preprocessed_image, config=custom_config)

    # Format text
    formatted_text = utils.formatted_text(text)
    extracted_data = utils.final_text(formatted_text)

    # Hapus file sementara
    os.remove(file_path)
    
    return jsonify({
        'success': True,
        'text': formatted_text,
        'data': extracted_data,
    })

if __name__ == '__main__':
    app.run(debug=True)