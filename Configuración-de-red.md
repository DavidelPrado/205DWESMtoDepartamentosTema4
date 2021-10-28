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