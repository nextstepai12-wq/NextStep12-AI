from fastapi import FastAPI

app = FastAPI(
    title="NextStep AI Service",
    description="PDF extraction service for university plans"
)


@app.get("/")
def root():
    return {
        "message": "NextStep AI Service Running"
    }