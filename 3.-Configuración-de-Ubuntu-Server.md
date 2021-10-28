## Actualización del sistema
Una vez terminada la instalación,  actualizar los repositorios --ver si hay algo nuevo--, es decir actualizar la lista de todos los paquetes, con la dirección de dónde obtenerlos para que a la hora de hacer la búsqueda y su posterior descarga, sea más rápida.
```
sudo apt update
````
y por último, la actualización de nuestro sistema con todas las posibles actualizaciones que pudiera haber, es decir no sólo actualiza nuestro sistema operativo sino que también las aplicaciones que están contenidas en los repositorios.
```
sudo apt upgrade
```
## Nombre de la máquina
### Paso 1.- Cambiar el nombre a la máquina
**PRIMER MÉTODO**
Aquí podemos cambiar el nombre del usuario
```
sudo nano /etc/hostname
```
Aquí debemos cambiar la opción "preserve hostname" a true para mantener los cambios
```
sudo nano /etc/cloud/cloud.cfg
```
**SEGUNDO MÉTODO**
Usando el siguiente comando
```
hostnamectl set-hostname nombremaquina
```
### Paso 2.- Cambiar el fichero  HOSTS
Editar el fichero hosts
```
sudo nano /etc/hosts
```
Cambiar el nombre de la máquina
```
127.0.0.1 localhost
127.0.1.1 nombremaquina
```
Paso 3.- Reiniciar la máquina
```
 reboot
```