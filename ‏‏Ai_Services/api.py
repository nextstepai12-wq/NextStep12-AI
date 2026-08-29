import os
import shutil
import tempfile
from fastapi import FastAPI, File, UploadFile, HTTPException, Query
from fastapi.middleware.cors import CORSMiddleware

# تم تصحيح المسارات هنا (إضافة src.)
from main import _parse
from src.models import ParserResponse

app = FastAPI(
    title="NextStep12 AI - Study Plan Parser API",
    description="API for parsing Palestinian University Study Plans from PDFs.",
    version="1.0.0"
)

# السماح للفرونت إند بالاتصال
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], # في الإنتاج ضع رابط الموقع فقط
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/api/health")
def health_check():
    return {"status": "API is running successfully!"}

@app.post("/api/parse", response_model=ParserResponse)
async def parse_study_plan(
    file: UploadFile = File(..., description="The PDF file of the study plan"),
    university_id: str = Query(None, description="Force a specific university ID (e.g., ucas_gaza)"),
    strict: bool = Query(False, description="Treat warnings as errors")
):
    if not file.filename.lower().endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Only PDF files are allowed.")

    # حفظ الملف مؤقتاً
    with tempfile.NamedTemporaryFile(delete=False, suffix=".pdf") as tmp_file:
        shutil.copyfileobj(file.file, tmp_file)
        tmp_path = tmp_file.name

    try:
        # استدعاء منطق البارسينج من main.py
        response = _parse(
            pdf_path=tmp_path,
            strict=strict,
            university_id=university_id
        )
        return response
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Parsing failed: {str(e)}")
    finally:
        # حذف الملف المؤقت
        if os.path.exists(tmp_path):
            os.remove(tmp_path)