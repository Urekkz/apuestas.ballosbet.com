--- 
customlog: 
  - 
    format: combined
    target: /etc/apache2/logs/domlogs/dannyguevarapumacall1757803038399.0870194.misitiohostgator.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /etc/apache2/logs/domlogs/dannyguevarapumacall1757803038399.0870194.misitiohostgator.com-bytes_log
documentroot: /home3/dannygue/public_html
group: dannygue
hascgi: 0
homedir: /home3/dannygue
ip: 10.53.65.87
owner: root
phpopenbasedirprotect: 1
phpversion: ea-php83
port: 80
scriptalias: 
  - 
    path: /home3/dannygue/public_html/cgi-bin
    url: /cgi-bin/
serveradmin: webmaster@dannyguevarapumacall1757803038399.0870194.misitiohostgator.com
serveralias: mail.dannyguevarapumacall1757803038399.0870194.misitiohostgator.com www.dannyguevarapumacall1757803038399.0870194.misitiohostgator.com
servername: dannyguevarapumacall1757803038399.0870194.misitiohostgator.com
usecanonicalname: 'Off'
user: dannygue
