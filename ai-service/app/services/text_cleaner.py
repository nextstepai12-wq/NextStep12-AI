import re
import unicodedata


def contains_arabic(text):

    if not text:
        return False

    return any(
        "\u0600" <= char <= "\u06FF"
        or "\uFB50" <= char <= "\uFDFF"
        or "\uFE70" <= char <= "\uFEFF"
        for char in text
    )


def fix_arabic(text):

    if not text:
        return None

    text = str(text).strip()

    text = re.sub(r"\s+", " ", text)

    # تحويل presentation forms
    text = unicodedata.normalize("NFKC", text)

    if contains_arabic(text):

        # عكس نصوص PDF العربية
        text = text[::-1]

        # إصلاح الأقواس
        text = text.translate(
            str.maketrans({
                ")": "(",
                "(": ")"
            })
        )

    return text


def clean_value(value):

    if value is None:
        return None

    value = str(value).strip()

    if value == "":
        return None

    return fix_arabic(value)