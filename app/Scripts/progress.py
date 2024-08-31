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


    return (arguments, weight, height, sex, age)

def density(age, sex, sum_skinfolds) -> float:
    density_by_age = 0
    if sex == 'Masculino':
        if 19 >= age > 15:
            density_by_age = round(1.162 - (0.063 * np.log10(sum_skinfolds)),2)
        elif 29 >= age:
            density_by_age = round(1.1631 - (0.0632 * np.log10(sum_skinfolds)),2)
        elif 39 >= age:
            density_by_age = round(1.1422 - (0.0544 * np.log10(sum_skinfolds)),2)
        elif 49 >= age:
            density_by_age = round(1.162 - (0.070 * np.log10(sum_skinfolds)),2)
        elif age >= 50:
            density_by_age = round(1.1715 - (0.0779 * np.log10(sum_skinfolds)),2)

    elif sex == 'Femenino':
        if 19 >= age > 15:
            density_by_age = round(1.1549 - (0.0678 * np.log10(sum_skinfolds)),2)
        elif 29 >= age:
            density_by_age = round(1.1599 - (0.0717 * np.log10(sum_skinfolds)),2)
        elif 39 >= age:
            density_by_age = round(1.1423 - (0.0632 * np.log10(sum_skinfolds)),2)
        elif 49 >= age:
            density_by_age = round(1.1333 - (0.0612 * np.log10(sum_skinfolds)),2)
        elif age >= 50:
            density_by_age = round(1.1339 - (0.0645 * np.log10(sum_skinfolds)),2)

    return density_by_age


def perimeters(skinfold, user_perimeters):
    # Perimetros corregidos
    fixed_perimeters = np.array([
        user_perimeters[0] - (0.314 * skinfold[1]),
        user_perimeters[1] - (0.314 * skinfold[1]),
        user_perimeters[2],
        user_perimeters[3] - (0.314 * skinfold[5]),
        user_perimeters[4] - (0.314 * skinfold[6]),
        user_perimeters[5] - (0.314 * skinfold[2]),
    ])

    sum_perimeters = sum(fixed_perimeters)
    return sum_perimeters

def antropometry(skinfold, user_perimeters, weight, height, sex, age):
    density_values = {
        'Masculino': [1.1765, 0.074],
        'Femenino': [1.1567, 0.0717]
    }
    slaughter_values = {
        'Masculino': [1.21, 0.008, 1.7],
        'Femenino': [1.33, 0.013, 2.5]
    }

    # Calcular IMC
    imc = round(float(weight) / (float(height) * float(height)),2)

    # Calcular suma de pliegues
    sum_skinfolds = sum(skinfold)

    # Calcular densidad
    density_by_age = density(age, sex, sum_skinfolds)
    if density_by_age == 0:
        density_by_age = round(density_values[sex][0] - (density_values[sex][1] * np.log10(sum_skinfolds)),2)


    if age >= 16:
        # Calcular porcentaje de grasa siri
        fat_percentage = round(((4.95 / density_by_age) - 4.50)*100,2)
    else:
        # Calcular porcentaje de grasa slaughter
        fat_percentage = round(slaughter_values[sex][0] * (skinfold[1] + skinfold[2]) - slaughter_values[sex][1] * ((skinfold[1] + skinfold[2])**2) - slaughter_values[sex][2],2)

    # Calcular perimetros
    fixed_perimeters = perimeters(skinfold, user_perimeters)
    z_muscular = round((fixed_perimeters * (170.18/(100*height)) - 207.21) /13.74, 2)
    masa_muscular = round(((z_muscular + 5.4)+24.5)/(170.18/(100*height))**3, 2)
    muscular_percentage = round((masa_muscular * 100 / weight), 2)
    pmb = round((user_perimeters[0] * 10) - (3.14*skinfold[1]), 2)
    amb = round((pmb)**2 / (4*3.14), 2)
    agb = round(((skinfold[1]*(user_perimeters[0]*10))/2) - ((3.14*(skinfold[1])**2)/4), 2)

    return imc, density_by_age, fat_percentage, z_muscular, masa_muscular, muscular_percentage, pmb, amb, agb

def main():

    try:
        values, weight, height, sex, age = handleInput()
        values = list(map(float, values))
        skinfold = np.array([values[0], values[1], values[2], values[3], values[4], values[5], values[6], values[7]])
        user_perimeters = np.array([values[8], values[9], values[10], values[11], values[12], values[13]])

        imc, density, fat_percentage, z_muscular, masa_muscular, muscular_percentage, pmb, amb, agb = antropometry(skinfold, user_perimeters, weight, height, sex, age)

        print("ok," + str(imc) + "," + str(density) + "," + str(fat_percentage) + "," + str(z_muscular) + "," + str(masa_muscular) + "," + str(muscular_percentage) + "," + str(pmb) + "," + str(amb) + "," + str(agb))

    except Exception as error:
        print("error,"+str(error))

if __name__ == '__main__':
    main()
