from motor.motor_asyncio import AsyncIOMotorClient
from pymongo.errors import PyMongoError

import os

DBM_ENGINE=os.getenv("DBM_ENGINE")
DBM_HOST=os.getenv("DBM_HOST")
DBM_PORT=os.getenv("DBM_PORT")
DBM_NAME=os.getenv("DBM_NAME")
DBM_USER=os.getenv("DBM_USER")
DBM_NAME = os.getenv("DBM_NAME")

class MongoDB:
    def __init__(self, uri: str, dbname: str):
        self.client = AsyncIOMotorClient(uri)
        self.db = self.client[dbname]

    async def close(self):
        self.client.close()

# Configura tu URI y nombre de base de datos
MONGODB_URI = f"{DBM_ENGINE}://{DBM_HOST}:{DBM_PORT}/"

mongodb = MongoDB(MONGODB_URI, DBM_NAME)