import pdfplumber
import arabic_reshaper
from bidi.algorithm import get_display


def fix_arabic(text):

    reshaped_text = arabic_reshaper.reshape(text)
    bidi_text = get_display(reshaped_text)

    return bidi_text



def extract_text(pdf_path: str):

    full_text = ""

    with pdfplumber.open(pdf_path) as pdf:

        for page in pdf.pages:

            text = page.extract_text()

            if text:
                text = fix_arabic(text)
                full_text += text + "\n"

    return full_text