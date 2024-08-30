import math
import numpy as np

def handleInput():
    arguments = sys.argv
    if (len(arguments) < 7):
        raise Exception("Faltan parámetros")
    del arguments[0]
    age = arguments.pop()
    sex = arguments.pop()
    height = arguments.pop()
    weight = arguments.pop()


    return (arguments, weight, height, sex, age)

def perimeters(skinfold, user_perimeters):
    # Perimetros corregidos
    fixed_perimeters = np.array([
        user_perimeters[0] - (0.314 * skinfold[1]),
        user_perimeters[1] - (0.314 * skinfold[1]),
        user_perimeters[2] - (0.314 * skinfold[1]),
        user_perimeters[3] - (0.314 * skinfold[5]),
        user_perimeters[4] - (0.314 * skinfold[6]),
        user_perimeters[5] - (0.314 * skinfold[2]),
    ])


def calculateData(skinfold, perimeters, weights, height, sex, age):
    density_values = {
        'Masculino': [1.1765, 0.074],
        'Femenino': [1.1567, 0.0717]
    }
    slaughter_values = {
        'Masculino': [1.21, 0.008, 1.7],
        'Femenino': [1.33, 0.013, 2.5]
    }


    # Calcular IMC
    imc = float(weight) / (float(height) * float(height))

    # Calcular suma de pliegues
    sum_skinfolds = float(suprailiac_skinfold) + float(supraspinal_skinfold)
                    + float(tricipital_skinfold) + float(bicipital_skinfold)

    # Calcular densidad
    density_h = density_values[sex][0] - (density_values[sex][1] * np.log(sum_skinfolds))

    if age >= 18:
        # Calcular porcentaje de grasa siri
        fat_percentage_siri = ((4.95 / density) - 4.50)*100
    else:
        # Calcular porcentaje de grasa slaughter
        fat_percentage_slaughter = slaughter_values[sex][0] * (tricipital_skinfold + subescapular_skinfold)
                                    - slaughter_values[sex][1] *(tricipital_skinfold + subescapular_skinfold)**2
                                    - slaughter_values[sex][2]
    # Calcular perimetros
    perimeters(skinfold, user_perimeters)


def main():
    try:
        values, weight, height, sex, age = handleInput()

        skinfold = np.array([values[0], values[1], values[2], values[3], values[4], values[5], values[6], values[7]])
        user_perimeters = np.array([values[8], values[9], values[10], values[11], values[12], values[13], values[14]])
        weights = np.array([values[15], values[16], values[17], values[18]])

        calculateData(skinfold, user_perimeters, weights, height, sex, age)
if __name__ == '__main__':
    main()
