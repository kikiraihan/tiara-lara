# ~/.bashrc: executed by bash(1) for non-login shells.

# Note: PS1 and umask are already set in /etc/profile. You should not
# need this unless you want different defaults for root.
PS1='${debian_chroot:+($debian_chroot)}\h:\w\$ '
umask 022

# You may uncomment the following lines if you want `ls' to be colorized:
export SHELL
export LS_OPTIONS='--color=auto'
eval $(dircolors ~/dircolors-solarized/dircolors.256dark)
alias ls='ls $LS_OPTIONS'
alias ll='ls $LS_OPTIONS -l'
alias l='ls $LS_OPTIONS -lA'

# Some more alias to avoid making mistakes:
alias rm='rm -i'
alias cp='cp -i'
alias mv='mv -i'

alias phpd='php -dzend_extension=xdebug.so -dxdebug.mode=debug -dxdebug.idekey=PHPSTORM -dxdebug.start_with_request=yes -dxdebug.client_host=host.docker.internal -dxdebug.client_port=9001'


#------------------------------------
#ALIAS KIKI
#------------------------------------


alias hg="history|grep"
alias pa="php artisan"

#alias ssh kongkong
alias kongs="ssh kongkon1@kongkong.web.id -p 423"

#alias git
alias ginit="git init"
alias gpom="git push origin main"
alias gpo="git push origin"
alias gpush="git push"
alias gpull="git pull"
alias gcm="git commit -m"
alias gcma="git commit --amend -m"
alias gall="git add ."
alias gadd="git add"
alias gcinfo="git config --list --show-origin" # cek semua config #tekan q untuk keluar
alias gs="git status"

#alias python dan pip
alias vbuat="python3 -m venv Env"
alias vpakai="source Env/bin/activate"
alias vpipupgrade="pip install --upgrade pip"
alias vpipupgraderforpip="pip install pip-upgrader"
alias vpi="pip install" #tambah -U untuk upgrade
alias vua="pip list --outdated --format=freeze | grep -v '^\-e' | cut -d = -f 1  | xargs -n1 pip install -U" #upgrade all package
alias vpigrep="pip list | grep"
#pip show <namapackage> #untuk cek detail package, termasuk version

#conda
alias condac="conda activate"
alias condec="conda deactivate"
alias cbuat="conda create --name" #env_tensorflow python=3.9
#conda create --prefix #./env ##ini membuat tapi pake env dalam folder project
#conda env remove --name ENV_NAME
alias condif="conda info --envs" #atau bgni juga boleh, conda env list
#conda list
#conda info
alias nb_dependency="conda install ipykernel" #nb_conda_kernels #dependensi untuk memunculkan env ke notebook
alias cexport="conda env export > environment.yml" #export env ke file yml

#stardog
alias sastart="stardog-admin server start" #--port=8080
alias sastop="stardog-admin server stop"

#alias jupyter
alias jp="jupyter notebook" #2latihan_python
alias jkuliah="jupyter notebook ~/2latihan_python/_Kuliah" #2latihan_python
alias jlatihan="jupyter notebook ~/2latihan_python" #2latihan_python


#alias docker
alias dockerc="docker container"
alias dockeri="docker image"
alias dcon="docker container"
alias dim="docker image"
alias runsementara="docker run --rm -d -t" #--name=namacontainer -p 8881:8888 --mount src="/Users/mohzulkiflikatili/2latihan_python",target=/app,type=bind namaimage
alias rstart="docker run --rm -d -t --name=jupyter -p 8881:8888 --mount src="/Users/mohzulkiflikatili/2latihan_python",target=/app,type=bind jupyter-python37"
alias rmasuk="docker exec -ti jupyter bash"
#run di container /app # jupyter notebook --ip='0.0.0.0' --port=8888 --no-browser --allow-root

# alias dps="docker ps"
# alias dpsa="docker ps -a"



#alias brew -> sama dengan apt di linux
alias cekportdari="lsof -i -n -P | grep"
alias bser="brew services"
#brew list
#brew list --version
#brew list --version git
#brew outdated #cek paket usang
#brew update
#brew upgrade
#brew doctor
#"brew services list"
#"brew services start"
# alias code='open -a "Visual Studio Code"'
alias editkan="code ~/.zshrc"
alias cekalias="cat ~/.zshrc"
alias calias="cat ~/.zshrc |grep"
alias salias="source ~/.zshrc"

alias fixpermis="sudo chown -R "$USER":admin" #path/to

# django command
alias pdj="python manage.py"