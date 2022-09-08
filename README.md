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
    - [Branch naming](#branch-naming)
    - [Commit Standars](#commit-standars)
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
Rellene de la siguiente forma
```
Which branch should be used for bringing forth production releases?
   - main
Branch name for production releases: [main] 
Branch name for "next release" development: [develop] 

How to name your supporting branch prefixes?
Feature branches? [] feature/
Bugfix branches? [] bugfix/
Release branches? [] release/
Hotfix branches? [] hotfix/
Support branches? [] 
Version tag prefix? [] 
Hooks and filters directory? [/home/emerson/Projects/yunex/.git/hooks] .git/git-flow-hooks
```

Finalmente clone el proyecto para el control semantico de version

```shell
cd .git; git clone git@github.com:jaspernbrouwer/git-flow-hooks.git; cd ..
```

Observacion.
> En adelante toda implementacion en el codigo debe hacerse a travez de ramas que propone gitflow
2. Construir y Levantar los contenedores de docker compose y ejecutar alias
```shell
make build
make up
```
```shell
source alias.sh
```
3. Ejecutar el gestor de dependencia Composer
```shell
composer install
```
4. Verifique si todo salio bien, con el siguiente comando:
```shell
sf --version
Symfony 6.1.4 (env: dev, debug: true) 
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
A continuacion se definiriar como nombrar las ramas y commits, estos tienen ligeros cambios a lo que usualmente se solia trbajar, ya que ahora se trabajara con JIRA Software.

### Branch Naming
Antes se debe conocer los tipos de branch los cuales son:
  - Regular Branch: Disponibles permanentemente en el repositorio
    - Developmente (Dev)
    - Main o master (Production)
    - QA o test
  - Temporary Branch: Los miembros del equipo puede agregar o eliminarlos.
    - Bug Fix (bugfix)
    - Hot Fix (hotfix)
    - Feature Branches (feature)  
    
Puede encontrar la definicion y la forma de uso de cada rama en el siguiente enlace [Branchin name](https://dev.to/couchcamote/git-branching-name-convention-cch)

1. **Start branch name with a Group word and slash separators**
El nombre de la rama debe empezar con el tipo de rama temporal que se detallo mas arriba y a continuacion un slash `/`. La herramienta de git-flow nos ayuda nombrando estas ramas.  
```shell
git flow start feature
git flow start bugfix
```
Esto produce ramas que empezaran por `feature/` o `bugfix/`

3. **Using unique issue tracker IDs in branch names**  
Agregar un identificador unico del issue, en este caso como se esta usando JIRA Software, la documentacion exige agregar el codigo del proyecto seguido por el ID de la incidencia. Esto nos permite asociar una rama con un tarea o subtarea de JIRA
```shell
git flow start feature YUN-25 ...
git flow start bugfix YUN-26 ...
```
Esto produce `feature/YUN-25` o `bugfix/YUN-26`  

4. **Add a short descriptor of the task & Use hyphens as separators**
Los nombres deben ser cortos con un maximo de 3 palabras, donde usualmente la primera palabra es un verbo que indica en resumen la accion de la funcionalidad, y el resto de palabras hacen referencia al modulo, sujeto del caso de uso entre otros.

```shell
git flow start feature YUN-45-save-customer
git flow start bugfix YUN-58-fix-validate-customer
```
Esto produce `feature/YUN-45-save-customer` o `bugfix/YUN-58-fix-validate-customer`

### Commit Standars
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