from flask import Flask, request, jsonify
import pytesseract
from PIL import Image
import os
import cv2
import numpy as np

app = Flask(__name__)

@app.route('/ocr', methods=['POST'])
def ocr():
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    
    file = request.files['file']
    
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400
    
    # Simpan file sementara
    temp_path = 'temp_image.jpg'
    file.save(temp_path)
    
    # Baca gambar dengan OpenCV
    img = cv2.imread(temp_path)
    
    # Preprocessing gambar
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    thresh = cv2.threshold(gray, 0, 255, cv2.THRESH_BINARY | cv2.THRESH_OTSU)[1]
    
    # Simpan gambar yang sudah diproses
    cv2.imwrite('processed_image.jpg', thresh)
    
    # Lakukan OCR
    text = pytesseract.image_to_string(Image.open('processed_image.jpg'), lang='ind')
    
    # Hapus file sementara
    os.remove(temp_path)
    os.remove('processed_image.jpg')
    
    return jsonify({
        'success': True,
        'text': text
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)