from fastapi import FastAPI, UploadFile, File
import shutil

from app.services.table_extractor import extract_tables
from app.services.json_builder import build_courses_json


app = FastAPI()


@app.post("/extract-plan")
async def extract_plan(file: UploadFile = File(...)):

    try:
        file_path = f"uploads/{file.filename}"

        with open(file_path, "wb") as buffer:
            shutil.copyfileobj(file.file, buffer)

        tables = extract_tables(file_path)

        plan = build_courses_json(tables)

        return {
            "status": "success",
            "semesters": plan
        }

    except Exception as e:

        return {
            "status": "error",
            "message": str(e)
        }