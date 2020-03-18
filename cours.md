# Au coeur du composant Routing de Symfony 5

## Usages basiques

### Route

```php
use Symfony\Component\Routing\Route;

$route = new Route('/une-url');
```

### RouteCollection

```php
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('maSuperUrl', $route);
```

### UrlMatcher

```php
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$matcher = new UrlMatcher($routes, new RequestContext());
$matcher->match("unPathInfo");
```

Si le matcher trouve une route, il renvoie un tableau :

```php
['_route' => 'maSuperUrl']
```

Si le matcher ne trouve pas de route, il renvoie une exception de type `Symfony\Component\Routing\Exception\ResourceNotFoundException`.

## Les routes

### Paramètres de routes

```php
$route = new Route('/une-url/{parametre}');
```

Si le matcher trouve une route, il renvoie un tableau :

```php
[
    '_route' => 'maSuperUrl',
    'parametre' => 'valeurDuParametre',
]
```

#### Valeurs par défaut pour les paramètres de routes

```php
$route = new Route('/une-url/{parametre}', ['parametre' => 'ValeurParDefault']);
```

On peut faire passer des paramètres qui n'existent pas dans la route

```php
$route = new Route('/une-url/{parametre}', ['parametre' => 'ValeurParDefault', 'toto' => 42]);
```

#### Requirements

Les requirements s'écrivent sous forme de regex (sans /.../).

```php
$showRoute = new Route(
    '/show/{id}',
    [],
    ['id'=>'\d+'],
);
```

#### Syntaxes alternatives

On peut écrire la regex d'un requirement directement dans le paramètre

```php
$showRoute = new Route('/show/{id<\d+>}');
```

On peut également spécifier qu'un paramètre est facultatif, en ajoutant un `?` à la fin dudit paramètre, dans le pathInfo.

```php
$showRoute = new Route('/show/{id<\d+>?}');
```

On peut enfin spécifier une valeur par défaut en ajoutant une valeur après le `?`.

```php
$showRoute = new Route('/show/{id<\d+>?100}');
```

### Host

On peut définir la forme que doit prendre le host pour qu'une route soit considérée comme valide.

```php
$route = new Route('/path', [], [], [], 'www.monsite.com')
```

Ici par exemple, des url du type `https://monsite.com/path` seront refusées.

Pour matcher des url du type `www.monsite.com`, `monsite.com` ou `api.monsite.com`, on peut ajouter un paramètre dynamique :

```php
$route = new Route('/path', [], [], [], '{subdomaine}.monsite.com');
```

### Schemes

On peut spécifier si une route est accessible via `http`, `https`, ou les deux.

```php
$route = new Route('/path', [], [], [], '', ['https']);
```

### Methods

On peut de même spécifier la ou les méthode(s) permissives pour une route.

```php
$route = new Route('/path', [], [], [], '', [], ['POST']);
```

### Précisions sur le `ContextRequest`

Il faudra faire attention à la précision de la définition du `ContextRequest`. Son constructeur prend par défaut un certain nombre de valeurs.
Exemple : les méthodes. La méthode par défaut du `ContextRequest` est `GET`. Si on ne spécifie rien, le script estimera que la route a été demandée en `GET`, quelle que soit la méthode réellement utilisée. Il faut donc spécifier au ContextRequest, à sa construction, quelle méthode est utilisée en ce moment.

```php
$matcher = new UrlMatcher($routes, new RequestContext('', $_SERVER['REQUEST_METHOD]));
```

Ceci est également valable pour les schemes et le host.

### UrlGenerator

```php
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

$generator = new UrlGenerator($routes, new RequestContext());
// Sans paramètres
$generator->generate('nomDeRoute');
// Avec paramètres
$generator->generate('nomDeRoute', ['parametre'=>'valeurDuParametre']);
```

## Lier les routes aux contrôleurs

On peut se servir de callables. Ce code :

```php
use Namespace\AcmeClass;

call_user_func([New AcmeClass, 'method']);
```

va appeler la méthode `method` de la classe `AcmeClass`. On peut donc passer ce tableau en paramètre de notre route :

```php
$route = new Route('/', ['controller'=>[New AcmeClass, 'method']]);
```

et nous servir de `call_user_func` pour appeler la méthode dynamiquement :

```php
call_user_func($route['controller']);
```

Notre contrôleur aura besoin très certainement besoin de la route courante, ne serait-ce que pour récupérer les paramètres éventuels. On lui passe donc aussi la route :

```php
call_user_func($route['controller'], $route);
```

Pour des raisons de performances (ne pas instancier des contrôleurs pour rien ou pire, les instancier plusieurs fois), on va déclarer une chaine de caractère dans la route et n'instancier le bon contrôleur qu'après le match effectué par le matcher.

```php
$route = new Route('/', ['controller'=>'Namespace\AcmeClass@method']);

$controller = explode('@', $route['controller'])[0];
$method = explode('@', $route['controller'])[1];

call_user_func([new $controller, $method], $route);
```

### Extraire la configuration des routes

On utilise le bundle `symfony/config`.

On crée tout d'abord un `PhpFileLoader` qui lui même prend en paramètres un `FileLocator` qui définit le chemin de nos fichiers de configuration, puis on importe les routes depuis le fichier `routes.php` que l'on va créer juste après.

```php
// index.php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\PhpFileLoader;

$loader = new PhpFileLoader(new FileLocator(__DIR__ . '/config'));
$routes = $loader->load('routes.php');

```

```php
// config/routes.php
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $configurator) {
    $configurator
        ->add('hello', '/hello/{name}')
        ->defaults(['name' => 'World', 'controller' => 'App\Controller\HelloController@SayHello'])
         ->requirements(['name'=>'{.3}'])
         ->methods(['POST', 'GET'])
         ->schemes(['http'])
         ->host('localhost')

        ->add('show', '/show/{id<\d+>}')
        ->defaults(['controller' => 'App\Controller\TaskController@show'])
        // etc
        ;
};
```

### Extraire la configuration au format YAML

Utilisation du bundle `symfony/yaml`. La mise en place est très semblable à l'exemple précédent:

```php
// index.php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

$loader = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
$routes = $loader->load('routes.yaml');
```

Puis :

```yaml
# config/routes.yaml
show:
    path: /show/{id}
    defaults:
        controller: 'App\Controller\TaskController@show'
        id: 100
    requirements:
        id: \d+
create:
    path: /create
    defaults:
        controller: 'App\Controller\TaskController@create'
    methods: [GET, POST]
    host: localhost
    schemes: [http]
```

### La méthode Controller (version PHP ou YAML)

Que ce soit en YAML ou en PHP, le mécanisme de configuration prévoit de traiter le cas des contrôleurs directement :

```yaml
# config/routes.yaml
show:
    path: /show/{id}
    controller: 'App\Controller\TaskController@show'
    defaults:
        id: 100
    requirements:
        id: \d+
create:
    path: /create
    controller: 'App\Controller\TaskController@create'
    methods: [GET, POST]
    host: localhost
    schemes: [http]
```

Cela va créer un paramètre `_controller` au sein de la route.

### Configurer les routes via Annotations

Une annotation est un commentaire commençant par un @ :

```php
use Symfony\Component\Routing\Annotation\Route;
class Test {

    /**
     * @Route(
     *      "/show/{id}",
     *      name="show",
     *      defaults={"id":100},
     *      requirements={"id":"\d+"}),
     *      schemes={"http, "https"},
     *      methods={"GET", "POST"},
     *      options={},
     *      host="localhost"
     * )
     *
     */
    public function show()
    {}

}
```

Doctrine ne sait pas charger automatiquement la classe `Route`. On va donc lui spécifier de passer par l'autoloader de Composer.

```php
// index.php
$classLoader = require __DIR__ . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$classLoader, 'loadClass']);
```

Il nous faut à présent un loader d'un nouveau type. Ce loader prend en paramètres un FileLocator, comme ses précédents confrères mais aussi une classe qui servira à faire le lien entre une route et la méthode de contrôleur à appeler. Nous allons définir cette classe car nous choisissons la façon dont ce lien est fait. La classe héritera de `Symfony\Component\Routing\Loader\AnnotationClassLoader`, qui est une classe abstraite et nous demande simplement d'implémenter la méthode `configureRoute()`. Voici un exemple de code pour cette méthode :

```php
// src/Loader/CustomAnnotationClassLoader.php
namespace App\Loader;

use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;

class CustomAnnotationClassLoader extends AnnotationClassLoader
{
    protected function configureRoute(Route $route, ReflectionClass $class, ReflectionMethod $method, $annot)
    {
        $route->addDefaults(['_controller' => $class->getName() . '@' . $method->getName()]);
    }
}
```

Nous pouvons à présent modifier notre loader :

```php
//index.php
use App\Loader\CustomAnnotationClassLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;


$loader = new AnnotationDirectoryLoader(new FileLocator(__DIR__ . '/src/Controller'), new CustomAnnotationClassLoader(new AnnotationReader));
$routes = $loader->load(__DIR__ . '/src/Controller');
```
