from fastapi import APIRouter, UploadFile, File, HTTPException
import os
import shutil

from app.services.pdf_extractor import extract_text

router = APIRouter()

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)


@router.post("/upload-pdf")
async def upload_pdf(file: UploadFile = File(...)):

    if not file.filename.lower().endswith(".pdf"):
        raise HTTPException(
            status_code=400,
            detail="Only PDF files are allowed."
        )

    file_path = os.path.join(UPLOAD_FOLDER, file.filename)

    # حفظ الملف
    with open(file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    # استخراج النص
    text = extract_text(file_path)

    # طباعة أول 1000 حرف في الـ Terminal
    print(text[:1000])

    # إرجاع أول 1000 حرف في الـ Response
    return {
        "message": "PDF uploaded successfully",
        "filename": file.filename,
        "pages_text_preview": text[:1000]
    }