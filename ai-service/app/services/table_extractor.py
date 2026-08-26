import pdfplumber


def extract_tables(pdf_path):

    all_tables = []

    with pdfplumber.open(pdf_path) as pdf:

        for page in pdf.pages:

            tables = page.extract_tables()

            for table in tables:

                # نأخذ فقط جداول المساقات
                if len(table) > 1:
                    header = table[0]

                    if header and "ﻕﺎﺴﻤﻟﺍ" in str(header):
                        all_tables.append(table)

    return all_tables