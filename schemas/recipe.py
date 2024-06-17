def recipeEntity(item) -> dict:
    return {
        "id": item["_id"],
        "label": item["recipe"].get("label"),
        "image": item["recipe"].get("image"),
        "level": item["recipe"].get("level"),
        "summary":item["recipe"].get("summary"),
        "calories": item["recipe"].get("calories"),
        "totalWeight": item["recipe"].get("totalWeight"),
        "ingredients": item["recipe"].get("ingredients"),
        "totalNutrients": item["recipe"].get("totalNutrients"),
        "totalDaily": item["recipe"].get("totalDaily"),
        "dietLabels": item["recipe"].get("dietLabels"),
        "healthLabels": item["recipe"].get("healthLabels"),
    }

def recipesEntity(entity) -> list:
    return [recipeEntity(item) for item in entity]