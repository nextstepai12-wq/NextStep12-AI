from services.table_extractor import extract_tables
from services.json_builder import build_courses_json
import json


pdf = "uploads/أمن المعلومات - الخطة الدراسية.pdf"


# استخراج الجداول من PDF
tables = extract_tables(pdf)


# تحويلها إلى JSON
result = build_courses_json(tables)


# عرض النتيجة للتأكد
print(json.dumps(
    result,
    ensure_ascii=False,
    indent=4
))


# حفظ الملف
with open(
    "app/data/study_plans.json",
    "w",
    encoding="utf-8"
) as f:

    json.dump(
        result,
        f,
        ensure_ascii=False,
        indent=4
    )


print("✅ تم حفظ study_plans.json")