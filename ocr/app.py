from flask import Flask, request, jsonify
from werkzeug.utils import secure_filename
from helper import utils
import pytesseract
import cv2
import os
import logging

app = Flask(__name__)

TEMP_DIR = os.getenv('TEMP_DIR', '/tmp')
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg'}

def allowed_file(filename):
    return '.' in filename and filename.split('.')[-1].lower() in ALLOWED_EXTENSIONS

@app.route('/ocr', methods=['POST'])
def ocr():
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    
    file = request.files['file']
    
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    if not allowed_file(file.filename):
        return jsonify({'error': 'Invalid file type'}), 400
    
    # Secure the filename and save temporarily
    filename = secure_filename(file.filename)
    file_path = os.path.join(TEMP_DIR, filename)

    try:
        file.save(file_path)
        
        # Read and process the image
        image = cv2.imread(file_path)
        if image is None:
            return jsonify({'error': 'Failed to read image'}), 400
        
        # Process the image
        preprocessed_image = utils.preprocessing(image)
        segmented_image = utils.process_image(preprocessed_image)
        extracted_data = utils.extract_image(**segmented_image)

        return jsonify({
            'success': True,
            'data': extracted_data
        })
    except Exception as e:
        logging.error(f'Error processing file: {str(e)}')
        return jsonify({'error': f'Internal server error: {str(e)}'}), 500
    finally:
        if os.path.exists(file_path):
            os.remove(file_path)

if __name__ == '__main__':
    app.run(debug=True)

# from flask import Flask, request, jsonify
# from werkzeug.utils import secure_filename
# from helper import utils
# import pytesseract
# import cv2
# import os
# import logging

# app = Flask(__name__)

# TEMP_DIR = os.getenv('TEMP_DIR', '/tmp')
# ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg'}

# def allowed_file(filename):
#     return '.' in filename and filename.split('.')[-1].lower() in ALLOWED_EXTENSIONS

# @app.route('/ocr', methods=['POST'])
# def ocr():
#     if 'file' not in request.files:
#         return jsonify({'error': 'No file part'}), 400
    
#     file = request.files['file']
    
#     if file.filename == '':
#         return jsonify({'error': 'No selected file'}), 400

#     if not allowed_file(file.filename):
#         return jsonify({'error': 'Invalid file type'}), 400
    
#     # Secure the filename and save temporarily
#     filename = secure_filename(file.filename)
#     file_path = os.path.join(TEMP_DIR, filename)

#     try:
#         file.save(file_path)
        
#         # Read and process the image
#         image = cv2.imread(file_path)
#         if image is None:
#             return jsonify({'error': 'Failed to read image'}), 400
        
#         # Preprocess the image
#         preprocessed_image = utils.preprocessing(image)

#         header_image = segmented_image['header_image']
#         column_images = segmented_image['column_images']

#         extracted_data = utils.extract_image(
#           header_image=header_image,
#           column_images=column_images
#         )

#         # Run OCR
#         custom_config = r'--oem 3 --psm 6'
#         text = pytesseract.image_to_string(preprocessed_image, config=custom_config)

#         # Format text
#         formatted_text = utils.formatted_text(text)
#         extracted_data = utils.extracted_data(formatted_text)
        
#         return jsonify({
#             'success': True,
#             'data': extracted_data
#         })
#     except Exception as e:
#         logging.error(f'Error processing file: {str(e)}')
#         return jsonify({'error': f'Internal server error: {str(e)}'}), 500
#     finally:
#         if os.path.exists(file_path):
#             os.remove(file_path)

# if __name__ == '__main__':
#     app.run(debug=True)