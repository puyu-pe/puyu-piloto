# Yunex

## Table of Contents

- [Intro](#intro)
- [About](#about)
- [Installing](#installing)
  - [Git](#git)
  - [Docker](#docker)
    - [Additional Notes](#additional-notes)
  - [Dependencies](#dependencies)
  - [Dotenv Files](#dotenv-files)
  - [Generate SSL and User](#Generate-SSL-and-User)
- [Standards](#standards)
  - [Analysis](#analysis)
  - [Code](#code)
    - [Easy Code Standard `ECS`](#easy-code-standard-ecs)
  - [Database](#database)
  - [Git standard](#git-standard)
    - [Branch naming](#branch-naming)
    - [Commit](#commit)
    - [Smart Commit](#smart-commit)
    - [Practical Example](#practical-example)
  - [Response JSON](#response-json)
- [Debug](#debug)
  - [Xdebug PHP](#xdebug-php)
  - [static-analysis-tool - `PHPStan`](#static-analysis-tool-phpstan)
- [Deprecated](#deprecated)
- [Disclaimers](#disclaimers)

## Intro

`Yunex` es un proyecto de la empresa Puyu para la misma empresa, donde se centralizara el control de diferentes procesos de la empresa.

## Acerca de
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

### Git

Para **instalar** Yunex debes tener instalado en entorno de desarrollo, previamente debes tener **docker** y **docker-compose**.
También debes tener instalado git, git-flow, y se promueve el uso de **Intellij IDEA,* ya que en esta herramienta se podrá estableces los estándares de programación como también el formateador de código.

Para poder descargar el código e inicializar git-flow:
```shell
git clone git@github.com:puyu-pe/yunex.git
cd yunex
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
Hooks and filters directory? [.git/hooks] .git/git-flow-hooks
```
- Creamos una copia de seguridad de los hooks por defecto de git de 
- Creamos un enlace simbólico a nuestros hooks penalizados
  - `hooks`: para que funcione los `(pre/post)-commit`
  - `git-fl0w-hooks`: para que funcione los hooks de git-flow


```shell
mv .git/hooks .git/hooks-bkp
ln -s $(pwd)/cicd/git-flow-hooks .git/
ln -s $(pwd)/cicd/git-flow-hooks .git/hooks
```

Observación.
> En adelante toda implementación en el código debe hacerse a través de ramas que propone git-flow

### Docker
Construir y Levantar los contenedores de docker compose
```shell
make rebuild
make run
```

#### Additional Notes
Ya que se está trabajando con contenedores, toda herramienta que se use en este proyecto debe ser a travez de contenedores, es decir las herramientas deben estar dentro de contenedores, registrarlas en **alias.sh** para poder usarlas en la session actual de la terminal .


### Dependencies
Para ejecutar los comandos de dependencias previamente se debe ejecutar:  
```shell
source alias.sh
```
Ejecutar el gestor de dependencia Composer
```shell
composer install
```
Verifique si todo salió bien, con el siguiente comando:
```shell
sf --version
Symfony 6.1.4 (env: dev, debug: true)

```
### Dotenv Files
Para poder iniciar con el proyecto es necesario crear un archivo Dotenv a partir del que trae el proyecto por defecto `/.env`, ejecute:
```shell
cp .env .env.local
```
Configure la Base de datos agregando la siguiente linea, asegúrese que no hay otra linea con configuración de Base de datos habilitado.

```shell
mysql://root:12345678@mysql:3306/yunex?serverVersion=8&charset=utf8mb4
```
### Generate SSL and User
#### SSL
El proyecto trabaja con la libreria de LexikJWTAuthenticationBundle para la generacion de JWT por lo que necesita los archivos `.pem`, ejecute

```shell
sf lexik:jwt:generate-keypair 
```
#### User
Para generar el usuario para interactuar por primera vez con la API ejecute el comando:

```shell
sf app:create-user --help
sf app:create-user username password fullName 1
```

Luego podra hacer login en el API ejecutando el el request que se encuentra en:  `http/user/UserLogin.http`  

## Standards
### Diagrama de trabajo YUNEX
Realizar el levantamiento y codificacion siguiendo el presente diagrama:

![alt text](https://drive.google.com/uc?export=view&id=1pQNAaJGPTM5bKyz3CLwkp82wiS2030lr)
 - **LINK DE ACCESO EN CAWEMO**

https://cawemo.com/diagrams/a2f9f637-d365-4e65-869f-6aa795421d04--diagrama-workflow-yunex?v=1049,476,0.549
### Analysis
Todo análisis debe documentarse, para poder generar la discución y el feedback necesario para mejorar el mismo analisis, (por el momento se decidio lo siguiente, a falta de invesntigación)
- Asignar todos los atributos o metadata necesaria en la tarea
- Documentar en tareas de Jira el analisis.

### Code
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
- Mejoras y modificación de PSR-2 - [PSR-12](https://www.php-fig.org/psr/psr-12/)

#### Easy Code Standard ECS
Para facilitar el cumplimiento descrito en el capítulo anterior, se usará una poderosa herramienta que verifique el cumplimiento de los estándares acordados en el equipo.

La herramienta es [Symplify/easy-code-standard](https://github.com/symplify/easy-coding-standard) que a su vez internamente usa :  
- [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) - Revisa y corrige código basado en estándares PEAR.
- [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) - Revisa y corrige código según el usuario establezca.

Las reglas de los estándares que se seguirán se define en el archivo `/ecs.php`  
El comando para poner en acción la herramienta es `./vendor/bin/ecs check src/`  

La herramienta ya fue personalizada en su archivo de configuracion para que revise `src/` y haga cumplir con los estandares de:
- Symfony clean code
- PSR-12  

En adelante se llamará al comando a través del alias:
```shell
ecs
```
Se puede especificar que archivos revisar, puede ser más de uno:  
```shell
ecs check src/Controller/Api/ContactController.php
```

Para aplicar las correcciones que mostrara la herramienta en consola se agrega el flag `--fix`  
```shell
ecs --fix
ecs check src/Controller/Api/ContactController.php --fix
```

### Database
La base de datos debe cumplir con los siguientes estandares.
- Las tables deben estar en ingles
- Los atributos deben estar en ingles

## Git Standard
A continuación se definirá como nombrar las ramas y commits, estos tienen ligeros cambios a lo que usualmente se solia trbajar, ya que ahora se trabajara con JIRA Software.

### Branch Naming
Antes se debe conocer los tipos de branch los cuales son:
  - Regular Branch: Disponibles permanentemente en el repositorio
    - Development (Dev)
    - Main o master (Production)
    - QA o test
  - Temporary Branch: Los miembros del equipo puede agregar o eliminarlos.
    - Bug Fix (bugfix)
    - Hot Fix (hotfix)
    - Feature Branches (feature)  
    
Puede encontrar la definición y la forma de uso de cada rama en el siguiente enlace [Branchin name](https://dev.to/couchcamote/git-branching-name-convention-cch)

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


### Commit
Los commits tendra un cambio a como se suele hacer, ya que se trabajara con JIRA, en esta plataforma tienen una variacion del commit, a lo que le llaman **Smart Commit**.  

> No ovlidar que los commit usualmente responden a la pregunta   
> (If applied, this commit will... "Add table Customer and columns")


Asi que nuestro commit podria ser:

```shell
git commit -m "Add table Customer and columns"

```

Un **Smart Commit**, no es otra cosa, que un commit, que podra verse en los comentarios de jira, asignarle tiempo invertido, y la posibilidad de indicarle a que estado cambia el issue.
mas información aqui [JIRA - Smart Commit](https://support.atlassian.com/bitbucket-cloud/docs/use-smart-commits/).

### Smart Commit
Los smart commit te permite agregar 3 comandos, y estos son:
- `comment` : comentario que se mostrara en el issue de JIRA  
- `time` : Tiempo que tomo el commit, se mostrara issue en JIRA  
- `transition`  : Cambiara de estado al issue, que pueden ser:
  - #todo : tareas por hacer
  - #in-progress : Se esta trabajando actualmente
  - #done : se termino de hacer

La sintaxis para estos commit es la siguiente.  
`<ISSUE_KEY> #comment `  



Ejemplo 1, algo simple:  
`YUN-97 #comment add standard to naming tables and columns`  

Ejemplo 2, combinando comandos:    
`YUN-97 #comment add standard to naming tables and columns #time 2h #done`

### Practical Example
Informacion sacada de [SCRUM - JIRA Software](https://www.atlassian.com/es/agile/project-management/user-stories) y modificada.  

Supongamos que tenemos la `historia de usuario` (US: user story) o en algunos casos `tarea` (Task) de YUNEX en el sprint actual y WIP actual:

`YUN-45`  
Como Vendedor  
quiero registrar las empresas clientes  
para llevar un mejor control

Una vez entendido la US se divide en `requisitos de software` o `tarea y/o subtareas`:  

- Entity analysis `YUN-46` solo genera discusión en el issue de JIRA y no un commit
- Make entity `YUN-47`
- Add Companies `YUN-48`
- Update Companies `YUN-49`
- Delete Companies `YUN-50`
- View Companies `YUN-51`

**Traduciendo al flujo de trabajo con JIRA y GIT**

1. Se puede crear una branch para US `YUN-45` como la siguiente:  
`feature/YUN-45-crud-company`

2. Se puede hacer commit por cada avance de los `Task`/`subtasks` o requisitos. Previa evaluacion de la histoia de usuario 
Ejemplo, una vez terminada el `Task` Make entity `YUN-47`, puedo hacer un commit muy completo (se puede presindir algunas recomendaciones).  

Luego de este comando:
```shell
git commit
```
se puede rellenar asi
```shell
    YUN-47 #comment Add table Customer and columns
    YUN-47 #time 4h 30m
    YUN-47 #done 
    
    (optional) added migrations and fixtures to seed data
```

Lo que provocara, un comentario en el issue, tiempo gastado o invertido en el issue y lo pasara a estado DONE o hecho, no olvidar que debe con cumplir con los `Definition of Done` (DoD) antes de cerrar.

## Response JSON

Las respuestas JSON del API deben cumplir con las siguientes reglas que se indican en el siguiente link:  
[JSEND](https://github.com/omniti-labs/jsend).  

Citando la parte más importante, sería estas reglas:  

### Success ### 
When an API call is successful, the JSend object is used as a simple envelope for the results, using the data key, as in the following:
#### GET /posts.json: ####
```
{
    status : "success",
    data : {
        "posts" : [
            { "id" : 1, "title" : "A blog post", "body" : "Some useful content" },
            { "id" : 2, "title" : "Another blog post", "body" : "More content" },
        ]
     }
}
```
#### GET /posts/2.json: ####
```
{
    status : "success",
    data : { "post" : { "id" : 2, "title" : "Another blog post", "body" : "More content" }}
}
```
#### DELETE /posts/2.json: ####
```
{
    status : "success",
    data : null
}
```
Required keys:

* status: Should always be set to "success".
* data: Acts as the wrapper for any data returned by the API call. If the call returns no data (as in the last example), data should be set to null.

### Fail ### 
When an API call is rejected due to invalid data or call conditions, the JSend object's data key contains an object explaining what went wrong, typically a hash of validation errors. For example:
#### POST /posts.json (with data body: "Trying to creating a blog post"): ####
```
{
    "status" : "fail",
    "data" : { "title" : "A title is required" }
}
```
Required keys:

* status: Should always be set to "fail".
* data: Again, provides the wrapper for the details of why the request failed. If the reasons for failure correspond to POST values, the response object's keys SHOULD correspond to those POST values.

### Error ### 
When an API call fails due to an error on the server. For example:
#### GET /posts.json: ####
```
{
    "status" : "error",
    "message" : "Unable to communicate with database"
}
```
Required keys:
* status: Should always be set to "error".
* message: A meaningful, end-user-readable (or at the least log-worthy) message, explaining what went wrong.

Optional keys:
* code: A numeric code corresponding to the error, if applicable
* data: A generic container for any other information about the error, i.e. the conditions that caused the error, stack traces, etc.


## Debug
### Xdebug PHP
Es altamente recomendado usar Xdebug para la depuración del código conjuntamente con el IDE Idea o PHPStorm.   
El manual para configurar y depurar con container [Configuring xdebug docker PHPStorm](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html#configuring-xdebug-docker)

Xdebug es una herramienta potente que permite hacer seguimiento sin limites a las variables en tiempo de ejecución.

### Static analysis tool `PHPStan`
PHPStan escanea todo su código base y busca tanto los errores obvios como los difíciles. Incluso en aquellas sentencias if que rara vez se ejecutan y que ciertamente no están cubiertas por las pruebas.

Se agregará a nuestro CI (Continuous Integration) de Github actions para evitar que esos errores lleguen a las ramas regulares.

La herramienta es [Phpstan/Phpstan](https://github.com/phpstan/phpstan), al igual que con ECS (Easy code standard), tiene un archivo de configuración `./phpstan.neon`.

Trabaja con extensiones para que pueda entender el codigo, metodos magicos y otros, fue configurado en este proyecto con las extensiones:  
- Symfony
- Doctrine  

Esta herramienta trabaja por [niveles](https://phpstan.org/user-guide/rule-levels), el equipo define en que nivel trabajar, que tan estrictos ser con el código.

La manera formal de llamar al comando es `./vendor/bin/phpstan analyse [file]`, se puede especificar más de un archivo.

El alias en este proyecto es `stan`, y ya fue configurado para que revise solo la carpeta `./src` con algunas excepciones. Ejecutarlo de esta forma revisar la estabilidad del codigo en toda la carpeta `./src`, en caso encuentre un posible error, mostrara en la consola, el error archivo la linea, y la recomentacion de como corregirlo en un **Link**
```shell
stan
```

Para revisar archivos específicos que pueden ser más de uno, sería algo asi:
```shell
stan analyse src/Controller/Api/ContactController.php 
```

## Disclaimers
Todos los estándares aquí, están sujetos a cambios y mejoras según se avance con esta nueva forma de trabajo.
Puede haber contradicciones o ambigüedades, por lo que se pide continua retro-alimentación, para mejorar todos estos estandares.


**Anteriormente nuestros commits tenían la siguiente sintaxis**
Ya no se seguirá esta convención en JIRA

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
```
