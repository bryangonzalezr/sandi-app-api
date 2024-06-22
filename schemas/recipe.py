def recipeEntity(item) -> dict:
    return {
        "id": str(item["_id"]),
        "label": item.get("label"),
        "calories": item.get("calories"),
        "glycemic_index": item.get("glycemicIndex"),
        "inflammatory_index": item.get("inflammatoryIndex"),
        "diet_labels": item.get("dietLabels"),
        "health_labels": item.get("healthLabels"),
        "cautions": item.get("cautions"),
        "ingredient_lines": item.get("ingredientLines"),
        "ingredients": item.get("ingredients"),
        "cuisine_type": item.get("cuisineType"),
        "meal_type": item.get("mealType"),
        "dish_type": item.get("dishType"),
        "instructions": item.get("instructions"),
        "tags": item.get("tags"),
        "total_weight": item.get("totalWeight"),
        "total_nutrients": item.get("totalNutrients"),
        "total_daily": item.get("totalDaily"),
        "digest": item.get("digest"),

    }

def recipesEntity(entity) -> list:
    return [recipeEntity(item) for item in entity]