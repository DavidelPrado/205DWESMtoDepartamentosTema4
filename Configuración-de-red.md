Primer paso entramos en el directorio de configuración de red 
cd /etc/netplan
Creamos una copia de seguridad del fichero de configuración 

```
sudo cp 00-installer-config.yaml 00-installer-config.backup
```
Editamos el fichero con
```
sudo nano 00-installer-config.yaml
```
Editaremos el fichero de configuración de la tarjeta de red
```

network:
  ethernets:
    enp0s3:
      addresses:
       - 192.168.1.100/24
      gateway4: 192.168.1.1
      nameservers:
         addresses:
         - 8.8.8.8
         search: [amor.local]
  version: 2
```
Aplicamos los cambios con
```
sudo netplan apply
```
COMPROBACIóN
 
Podemos mirar la configuración con ```ifconfig``` (se necesita tener instalado el net tools)
Actualmente se utiliza la utilidad ```ip ```a s ```(ip addr show) ```muestra todas las interfaces disponibles en el sistema.
Podemos hacer ```ping ```  para saber si tenemos salida a Internet, por ejemplo ```ping www.google.es```
Con ip r podemos mirar el gateway
```resolvectl status ``` muestra la configuración de los DNS de la máquina