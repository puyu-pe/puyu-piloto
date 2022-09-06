# Yunex

<!-- To update this table of contents, ensure you have run `npm install` then `npm run doctoc` -->
<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [Intro](#intro)
- [About](#about)
- [Installing and Updating](#installing-and-updating)
    - [Install & Update Script](#install--update-script)
        - [Additional Notes](#additional-notes)
- [Standars](#standards)
    - [Analysis](#analysis-standards)
    - [Code](#code-standards)
    - [Database](#datbase-standars)
    - [Git](#git-standars)
- [Maintainers](#maintainers)
- [License](#license)
- [Copyright notice](#copyright-notice)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Intro

`Yunex` es un proyecto de la empresa Puyu para la misma empresa, donde se centralizara el control de diferentes procesos de la empresa.

## About
`Yunex`

Los procesos que por el momento se han planeado agregar son:

- Gestión de proyectos:
    - Permite gestionar los servicios que se habilita al cliente.
- Gestión de planes
    - Permite controlar los planes mensuales o anuales que se brinda a los clientes.

Etc.

<a id="installation-and-update"></a>
<a id="install-script"></a>
## Installing

### Install & Update Script

Para **instalar** Yunex debes tener instalado en entorno de desarllo, previamente debes tener **docker** y **docker-compose**.
Tambien debes tener instaladpo git, y se promueve el uso de **Intellij IDEA* ya que en esta herramienta se podra estableces los estandares de progrmacion como tambien el formateador de codigo.

1.  Para poder descargar el codigo e inicializar git-flow:
```shell
git clone git@github.com:puyu-pe/yunex.git
``` 
```shell
git flow init
```
Observacion.
> En adelante toda implementacion en el codigo debe hacerse a travez de ramas que propone gitflow
2. Construir y Levantar los contenedores de docker compose y ejecutar alias
```shell
make build
make run
```
```shell
source alias.sh
```
3. Ejecutar el controlador de dependencia Composer
```shell
composer install
```

#### Additional Notes
ya que se estra trabajando con contenedores, toda herramienta que se use en este proyecto debe ser a travez de contenedores, es decir las herramientas deben estar dentro de contenedores, registrarlas en **alias.sh** para poder usarlas en la session actual de la terminal .

## Standars
### Analysis Standards
Todo analisis debe documentarse, para poder generar la discución y el feedback necesario para mejorar el mismo analisis, (por el momento se decidio lo siguiente, a falta de invesntigación)
- Asignar todos los atributos o metadata necesaria en la tarea
- Documentar en tareas de Jira el analisis.

### Standards Code
El proyecto debe cumplir los siguientes estandares de codigo/programación

- Cumplir con los principios SOLID:  
Debe cumplir con los 5 principios solid - [SOLID para PHP](https://diego.com.es/solid-principios-del-diseno-orientado-a-objetos-en-php)

- Cumplir con los PSR-PHP que se indican:  
El proyecto debe cumplir obligatoriamente con los PSR indicados mas abajo.
El desarrollador debe ser capas de entender la estructura y documentacion PSR de la pagina oficial - [PSR-PHP](https://www.php-fig.org/psr/) 
Asi tambien como las palabras claves en esta documentacion PSR:  `"MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL"`.

Cumplir con los siguientes PSR:  
  - Estandares basicos de programación - [PSR-1](https://www.php-fig.org/psr/psr-1/)
  - Guia de estilos de codigificación - [PSR-2](https://www.php-fig.org/psr/psr-2/)
  
### Database Standars
La base de datos debe cumplir con los siguientes estandares.
- Las tables deben estar en ingles
- Los atributos deben estar en ingles

## Git Standars

```shell
# <type>: (If applied, this commit will...) <subject> (Max 50 char)
# |<----  Using a Maximum Of 50 Characters  ---->|


# Explain why this change is being made
# |<----   Try To Limit Each Line to a Maximum Of 72 Characters   ---->|

# Provide links or keys to any relevant tickets, articles or other resources
# Example: Github issue #23

# --- COMMIT END ---
# Type can be 
#    feat     (new feature)
#    fix      (bug fix)
#    refactor (refactoring production code)
#    style    (formatting, missing semi colons, etc; no code change)
#    docs     (changes to documentation)
#    test     (adding or refactoring tests; no production code change)
#    chore    (updating grunt tasks etc; no production code change)
# --------------------
# Remember to
#   - Capitalize the subject line
#   - Use the imperative mood in the subject line
#   - Do not end the subject line with a period
#   - Separate subject from body with a blank line
#   - Use the body to explain what and why vs. how
#   - Can use multiple lines with "-" for bullet points in body
# --------------------
# For updated template, visit:
# https://gist.github.com/adeekshith/cd4c95a064977cdc6c50
# Licence CC
```