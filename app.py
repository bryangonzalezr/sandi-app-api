from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from routes.recipe import recipe
from routes.daymenu import daymenu
from routes.menu import menu

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


app.include_router(recipe)
app.include_router(daymenu)
app.include_router(menu)

if __name__ == "__app__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8080)
