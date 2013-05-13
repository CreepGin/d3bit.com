@echo OFF
CALL lessc -x watchr/less/all.less > css/style.css
CALL cd watchr/js
CALL copy /b *.js all.js
CALL move all.js ../../js
CALL cd ..
CALL cd ..
CALL uglifyjs -nc js/all.js > js/script.js
CALL DEL /F js\all.js