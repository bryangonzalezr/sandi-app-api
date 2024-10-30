import sys
import numpy as np

def handleInput():
    arguments = sys.argv
    if (len(arguments) < 7):
        raise Exception("Faltan parámetros")
    del arguments[0]

    age = int(arguments.pop())
    sex = arguments.pop()
    height = float(arguments.pop())
    weight = float(arguments.pop())
    patient_type = arguments.pop()
    physical_activity = arguments.pop()
    nutritional_state = arguments.pop()
    rest_factor = arguments.pop()
    pathology = arguments.pop()
    dislipidemia = arguments.pop()
    tiroides = arguments.pop()
    hta = arguments.pop()
    dm2 = arguments.pop()
    method = arguments.pop()

    return (method, dm2, hta, tiroides, dislipidemia, pathology, rest_factor, nutritional_state, physical_activity, patient_type, weight, height, sex, age)

def idealWeight(height, sex):
    if (sex == "Masculino"):
        ideal_weight = 22.5 * (height ** 2)
        return ideal_weight
    elif (sex == "Femenino"):
        ideal_weight = 21.5 * (height ** 2)
        return ideal_weight

def adjustedWeight(weight, ideal_weight):
    adjusted_weight = ideal_weight + (0.25 * (weight - ideal_weight))
    return adjusted_weight

def normalGet(weight, height, nutritional_state, physical_activity, ideal_weight):
    energetic_requirement = {
        "Enflaquecido": {"Leve": 35, "Moderada": 40, "Pesada": 45},
        "Normal": {"Leve": 30, "Moderada": 35, "Pesada": 40},
        "Sobrepeso": {"Leve": 25, "Moderada": 30, "Pesada": 35},
        "Obesidad": {"Leve": 25, "Moderada": 30, "Pesada": 35}
    }
    weights = {
        "Enflaquecido": weight,
        "Normal": weight,
        "Sobrepeso": ideal_weight,
        "Obesidad": adjustedWeight(weight, ideal_weight)
    }

    get = energetic_requirement[nutritional_state][physical_activity] * weights[nutritional_state]
    return get

def faoGet(weight, physical_activity, age, sex):

    coefficients = {
        "Masculino": [
            (3, 60.9, -54),
            (10, 22.7, 495),
            (18, 17.5, 651),
            (30, 15.3, 679),
            (60, 11.6, 879),
            (float('inf'), 13.5, 487)
        ],
        "Femenino": [
            (3, 61, -51),
            (10, 22.5, 499),
            (18, 12.2, 746),
            (30, 14.7, 496),
            (60, 8.7, 829),
            (float('inf'), 10.5, 596)
        ]
    }

    for age_limit, coefficient1, coefficient2 in coefficients[sex]:
        if age <= age_limit:
            geb = coefficient1 * weight + coefficient2
            break

    activity_factor = {
        "Leve": geb * 1.1,
        "Moderada": geb * 1.3,
        "Pesada": geb * 1.5,
    }

    eta = geb * 0.1
    get = geb + activity_factor[physical_activity] + eta
    return get

def harrisBenedictGet(weight, height, age, sex, rest_factor, pathology):

    if sex == "Masculino":
        ger = 66.47 + (13.74 * weight) + (5.03 * height * 100) - (6.75 * age)
    elif sex == "Femenino":
        ger = 655.1 + (9.56 * weight) + (1.85 * height * 100) - (4.68 * age)

    fr = {
        "Absoluto": 1.1,
        "Relativo": 1.2,
        "Ambulatorio": 1.3,
    }

    fp = {
        "Hipometabolismo": {"Masculino": 0.87, "Femenino": 0.81},
        "Tumor": {"Masculino": 1.15, "Femenino": 1.25},
        "Leucemia / Linfoma": {"Masculino": 1.19, "Femenino": 1.27},
        "Enfermedad Inflamatoria Intestinal": {"Masculino": 1.07, "Femenino": 1.12},
        "Quemadura": {"Masculino": 1.52, "Femenino": 1.64},
        "Enfermedad Pancreática": {"Masculino": 1.13, "Femenino": 1.51},
        "Cirugía General": {"Masculino": 1.2, "Femenino": 1.39},
        "Transplante": {"Masculino": 1.19, "Femenino": 1.27},
        "Infección": {"Masculino": 1.33, "Femenino": 1.27},
        "Sepsis / Abscesos": {"Masculino": 1.12, "Femenino": 1.39},
        "Ventilación Mecánica": {"Masculino": 1.34, "Femenino": 1.32},
        "Cirugía Menor": 1.2,
        "Cirugía Mayor": 1.4,
        "Sepsis": 1.3,
        'Quemadura 20%': 1.5,
        'Quemadura 40%': 1.85,
        'Quemadura 100%': 2.05,
        "Politraumatismo": 1.5,
        "Politraumatismo y Sepsis": 1.6,
        "Desnutrición Leve": 1.15,
        "Desnutrición Moderada": 1.25,
        "Desnutrición Severa": 1.40,
        "Desnutrición sin estrés": 0.85
    }

    if pathology in fp:
        if sex in fp.values():
            return ger * fr[rest_factor] * fp[pathology][sex]
        else:
            return ger * fr[rest_factor] * fp[pathology]

def factorialGet(weight, height, nutritional_state, physical_activity, pathology, ideal_weight):
    energetic_requirement = {
        "Enflaquecido": {"Leve": 35, "Moderada": 40, "Pesada": 45},
        "Normal": {"Leve": 30, "Moderada": 35, "Pesada": 40},
        "Sobrepeso": {"Leve": 25, "Moderada": 30, "Pesada": 35},
        "Obesidad": {"Leve": 25, "Moderada": 30, "Pesada": 35}
    }

    weights = {
        "Enflaquecido": weight,
        "Normal": weight,
        "Sobrepeso": ideal_weight,
        "Obesidad": adjustedWeight(weight, ideal_weight)
    }

    if (pathology == "Edema Severo" or pathology == "Ascitis"):
        return energetic_requirement[nutritional_state][physical_activity] * adjustedWeight(weight, ideal_weight)
    elif (pathology == "Desnutrición Leve" or pathology == "Desnutrición Moderada" or pathology == "Desnutrición Severa" or pathology == "Desnutrición sin estrés"):
        return energetic_requirement[nutritional_state][physical_activity] * weight
    else:
        return energetic_requirement[nutritional_state][physical_activity] * weights[nutritional_state]

def calculateGet(method, dm2, hta, tiroides, dislipidemia, pathology, rest_factor, nutritional_state, physical_activity, patient_type, weight, height, sex, age):
    if (patient_type == "Ambulatorio"):
        if (method == "Normal"):
            return round(normalGet(weight, height, nutritional_state, physical_activity, idealWeight(height, sex)), 2)
        elif (method == "FAO/OMS/ONU"):
            return round(faoGet(weight, physical_activity, age, sex), 2)
        else:
            return 0
    else:
        if (method == "Factorial"):
            return round(factorialGet(weight, height, nutritional_state, physical_activity, pathology, idealWeight(height, sex)), 2)
        elif (method == "Harris-Benedict"):
            return round(harrisBenedictGet(weight, height, age, sex, rest_factor, pathology) , 2)
        else:
            return 0

def macronutrients(get, weight, ideal_weight, nutritional_state):
    weights = {
        "Enflaquecido": weight,
        "Normal": weight,
        "Sobrepeso": ideal_weight,
        "Obesidad": adjustedWeight(weight, ideal_weight)
    }

    protein = round((get * 0.2) / 4 ,0)
    lipids = round((get * 0.26) / 4 ,0)
    carbohydrates = round((get * 0.54) / 4 , 0)
    return protein, lipids, carbohydrates

def waterConsumption(get):
    water = round(get * 1.3 ,0)
    return water

def main():
    try:
        method, dm2, hta, tiroides, dislipidemia, pathology, rest_factor, nutritional_state, physical_activity, patient_type, weight, height, sex, age = handleInput()
        get = round(calculateGet(method, dm2, hta, tiroides, dislipidemia, pathology, rest_factor, nutritional_state, physical_activity, patient_type, weight, height, sex, age),0)
        protein, lipids, carbohydrates = macronutrients(get, weight, idealWeight(height, sex), nutritional_state)
        water = waterConsumption(get)

        if (get == 0):
            print("error, Método seleccionado no válido para tipo de paciente")

        print("ok," + str(get) + "," + str(protein) + "," + str(lipids) + "," + str(carbohydrates) + "," + str(water))

    except Exception as error:
        print("error," + str(error))

if __name__ == '__main__':
    main()
