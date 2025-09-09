from PIL import Image
from helper import utils
import pytesseract
import sys

if __name__ == "__main__":
    image_path = sys.argv[1]
    image = Image.open(image_path)

    preprocessed_image = utils.preprocessing(image)
    segmented_image = utils.process_image(preprocessed_image)
    extracted_data = utils.extract_image(**segmented_image)

    sys.stdout.write(json.dumps({'data': extracted_data}))
    sys.stdout.flush()
