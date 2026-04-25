# Guía de Desarrollo: Rutas y Controladores

Esta documentación explica los pasos necesarios para agregar nuevas rutas al proyecto

## 1. Crear un .php en la carpeta /views/pages

Antes que nada debes crear un archivo .php en la ruta `/views/pages` esto sevira como un ".html" de la pagina donde podras toda la vista de la pagina. Por ejemplo crear un archivo `Ejemplo.php` (aqui adentro puedes escribir codigo html tranquilamente)

## 2. Crear el Controller correspondiente

Cada pagina de la web debe venir acompañada de un `Controller`, esto es lo que realmente controla lo que se ve. Se tiene que crear en la ruta `app/Controllers` preferiblemente con la siguiente nomenclatura: `<nombre de la ruta>Controller.php`. Existe el siguiente `ExamplController.php` para poder copiar y pegar al momento de crear una nueva ruta para tener como base:

```php
<?php

namespace App\Controllers;

use App\Core\Controller;

//La clase debe tener el mismo nombre que el archivo
class ExampleController extends Controller
{

    public function index()
    {

        return $this->view('pages/example', [
            'title' => 'Página de ejemplo'
        ]);
    }
    public function exampleID($id){

          return $this->view('pages/exampleID', [
            'id' => $id
        ]);
    }

}
```

Esto funciona muy simple, lo vital es tener un metodo (que puede llamarse de cualquier forma pero para seguir una nomenclatura comenzaremos por index) que va a renderizar la pagina creada en el punto anterior. En este metodo se puede hacer cualquier tipo de logica antes de renderizar la pagina como hacer consultas a una base de datos, lo imporante es que al final retorne lo siguiente:

```php
 return $this->view('pages/example', []);
```

`this->view("",[])` esto es lo que termina renderizando la pagina, sin esto no se va a ver nada. El metodo view recibe dos parametros, el primero es un `string` que sera la ruta de nuestro .php generado en el punto 1. Si por ejemplo crearte `views/pages/about.php` aqui debes ingresar `"pages/about"` (sin el .php ni el view). Y como segundo parametro recibe un array donde cada item tiene la estructura:

```php
[
    'key'=>'valor',
    'key 2' => 'valor 2'
]
```

El valor no tiene que ser un string, puede ser un numero o cualquier tipo de dato. Esto lo que hara sera pasar datos al front (el .php creado en el punto 1) y poder tener ese datos desde ahi.

## 3 Declarar la ruta

ya tenemos la vista y lo que la renderiza, ahora falta en donde mostrarlo. Para eso ahora hay que ir al archivo `routes/web.php`, aqui se debe declarar la ruta (en que parte se va a mostrar esta pagina que creamos). Para declarar la ruta es la siguiente forma:

```php
$router->get('<ruta>','<nombre del archivo controller@<nombre de la funcion>');

```

Con declarar en cualquier parte de `web.php` lo tomara. El metodo get de $router toma dos parametros.

- El primero es un `string` que sera el endpoint donde se mostrara la vista, si quieres que al entrar a `/about` desde la URL y se vea aqui escribes `/about`.
- El segundo parametro tambien es un string que tiene que ver con el controller. Este string tiene dos partes: `<nombre del controller` (por ejemplo ExampleController) `@` (arroba importante) y `<nombre de la funcion>` (de la funcion que va a renderizar la vista). Un ejemplo de esto seria `'ExampleController@index'`.

## 4. Rutas con parametros dinamicos

Aveces necesitamos tener una ruta con un parametro dinamicos. Por ejemplo tenemos una ruta `/sillones` que queremos que pueda mostrar cada sillon especifico, para podemos pasarle la ID del sillon por la URL por ejemplo y entrar a la ruta `/sillones/12345` y con ese ID hacer una peticion a la base de datos. Para poder hacer eso casi todos los pasos son iguales cambiando un par de cosas.

### 4.1. En la declaracion de la ruta

```php
$router->get('/sillones/{id}','SillonesController@index');
```

La declaracion de la ruta sigue siendo igual salvo que se agrega un `{id}` (el nombre de esto no tiene que ser necesariamente id, puedes darle el nombre que necesites mientras que sea entre llaves)

### 4.2. En el controller

```php
    public function index($id){

          return $this->view('pages/sillonesID', [
            'id' => $id,

        ]);
    }
```

En un supuesto `SillonesController.php` en su metodo index se le pasara por parametros de esta funcion la cantidada de datos dinamicos que hayas puesto en la URL. Aqui podrias usar el dato dinamico para hacer consultas a la base de datos, pasarlo al front, etc. Lo que necesites.

### 4.3. ¿Se puede mas de un parametro dinamico?

Si, solo tendrias que poner mas al declarar la ruta. Por ejemplo `'/sillones/{id}/{idDOS}/{idTRES}'`

y en el controller solo agregar mas parametros:

```php
public function index($id,$idDOS,$idTRES){}
```
