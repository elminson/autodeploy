#!/bin/sh
dir="/var/repo/$@.git"

if [ ! -d $dir ]
then
    mkdir $dir

    cd $dir
    #mkdir repo && cd repo
    #mkdir $@.git && cd $@.git
    git init --bare
    pwd
    cd hooks
    ls
    touch post-receive
    ls
    pwd
    echo "#!/bin/sh" >> post-receive
    echo "git --work-tree=/var/www/$@ --git-dir=/var/repo/$@.git checkout -f" >> post-receive
    chmod +x post-receive
    echo 'Test command'
    echo $@
fi
