import re
import unicodedata

from services.text_cleaner import clean_value



def build_courses_json(tables):

    semesters = []

    for index, table in enumerate(tables):

        courses = []


        for row in table[1:]:

            if not row or len(row) < 7:
                continue


            course_name = clean_value(row[6])


            if not course_name:
                continue


            if "المجموع" in course_name:
                continue



            course = {

                "course_name": course_name,

                "course_code": clean_value(row[5]),

                "credit_hours": row[4],

                "theory_hours": row[3],

                "practical_hours": row[2],

                "course_type": clean_value(row[1]),

                "prerequisite": clean_value(row[0])

            }


            courses.append(course)


        semesters.append({

            "semester_number": index + 1,

            "courses": courses

        })


    return semesters