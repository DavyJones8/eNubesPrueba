# Manual prueba eNubes

## Por Ignacio Valero Calvo - 2020


## Instrucciones prueba

·​ ​Registro (Nombre, Apellidos, Contraseña (encriptada), Captcha, email)
o​ ​Al enviar el usuario el formulario de registro, este tiene que recibir un
email dándole las gracias por haberse registrado en el sitio.
·​ ​Pantalla de login (Email,Contraseña )
·​ ​Una home con noticias (parte públicas, parte privadas)
·​ ​ADMINISTRACIÓN
o​ ​CRUD de usuarios
§​ ​Cada usuario tendrá permiso a X noticias, no a todas.
§​ ​Desde el apartado de usuarios se podrá crear, editar y borrar el
usuario, así como autorizarlo para que pueda acceder a la parte
privada.
o​ ​CRUD de noticias
§​ ​Una noticia estará compuesta por título, contenido y fecha de
inserción.
§​ ​Estado de la noticia (Pública, Privada, Publicada, No publicada)
§​ ​La noticia se podrá crear, editar, borrar y cambiar de estado desde
esta sección.
o​ ​Estadísticas de la página web
§​ ​Número de usuarios
§​ ​Número de noticias
§​ ​Número de visitas por noticia
§​ ​Gráfico usando un plugin de jquery con los visitantes de cada una
de ellas.


## Funcionamiento

### Roles, usuarios y contraseñas predeterminados

```
Usuarios “Admin” con acceso a la parte de administración y gestión, así como a todo tipo de
noticias:
Usuarios “Vip” con acceso a noticias publicadas tanto públicas como privadas:
Usuarios “Miembro” con acceso a noticias publicadas sólo públicas.
```
### Login y registro

```
Al acceder a la web, la primera página que se mostrará será la del “Login”, donde se podrá
iniciar sesión si se dispone de usuario o registrarse.
Pulsando “Registrarse” se abrirá la ventana que inicia el registro. Se deberán cumplimentar
los campos del formulario, así como completar el “Captcha”. Al confirmar, se formalizará el
registro y se recibirá un email de bienvenida en el correo indicado.
```

### Home

Una vez iniciada la sesión, habrá una redirección a la ventana “Home”, en la que
dependiendo del grado de permisos que tenga el usuario logueado, mostrará o no la sección
“Administración” y las noticias que tenga permitido visualizar.
El “Admin” podrá ver todas las noticias, estén publicadas/no publicadas o sean
públicas/privadas, además de que tendrá una botonera en cada noticia que le permitirá
modificar el estado de esta, editarla en una nueva ventana o eliminarla.
El “Vip” podrá ver las noticias publicadas tanto públicas como privadas y podrá acceder a la
botonera antes mencionada si la noticia la ha registrado él.
El “Miembro” podrá ver las noticias publicadas que sean públicas y podrá acceder a la
botonera antes mencionada si la noticia la ha registrado él.
Pulsando “Seguir leyendo”, se abre una nueva ventana donde se podrá visualizar todo el
contenido de la noticia.
En la barra de navegación superior, pulsando “eNubes News” se volverá a la página
principal.


### Crear noticia

En la barra superior de navegación se encuentra el botón “Crear noticia”. Pulsando abrirá
una vista en la que se puede crear una imagen con un editor con diversas funciones.
El “Admin” y el “Vip” serán los únicos con acceso a cambiar la privacidad al crear o editar
una noticia.

### Icono usuario

Al lado de “Crear noticia” se encontrará el botón de usuario. Pulsando aquí se despliegan 3
opciones:

1. Mis noticias: Abrirá una ventana con las noticias registradas por el usuario
2. Mi cuenta: Desplegará una vista en la que se podrán modificar los datos del usuario.


3. Cerrar sesión: Termina la sesión y vuelve a la página del Login.

### Administración

El “Admin” tendrá acceso a esta pestaña de la barra de navegación. Pulsando, se
despliegan 3 opciones:

1. Gestión de noticias: Mostrará una nueva ventana con una tabla y todas las noticias
    registradas en la que se podrán realizar varias acciones:
       a. Cambiar el estado de la noticia
       b. Cambiar la privacidad de la noticia
       c. Editar la noticia
       d. Borrar la noticia


2. Gestión de usuarios: Abrirá una vista donde se podrá visualizar a todos los usuarios,
    cambiar su rol y/o eliminarlo si así se deseara.
3. Estadísticas: Se mostrará un panel de control en el que poder observar las
    estadísticas de la web.
    Primero se mostrará un conteo del total de usuarios y noticias registrados en la web
    hasta ese momento.
    Tras eso, se despliega una tabla con todas las noticias. las visitas por cada una de
    ella y una botonera de acciones:
       
        1. Botón “detalle noticia” (gris): Llevará a la noticia seleccionada para
          visualizarla
        2. Botón “gráfica visitas” (azul): Mostrará en la parte inferior un gráfico de área
        con las visitas a la noticia seleccionada durante los últimos 30 días, pudiendo
        seleccionar otros dos períodos:
        3. Botón “gráfica visitantes” (verde): Mostrará en la parte inferior un gráfico por
        barras de los visitantes para la noticia seleccionada durante los últimos 30
        días, pudiendo seleccionar otros dos períodos.



