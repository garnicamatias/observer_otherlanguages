<?php

SplSubject {
    /* Methods */
    abstract public void attach ( SplObserver $observer )
    abstract public void detach ( SplObserver $observer )
    abstract public void notify ( void )
}
SplObserver {
    /* Methods */
    abstract public void update ( SplSubject $subject )
}

class Blog implements SplSubject
{
    protected $posts = [];
    protected $storage;
    public function __construct()
    {
        $this->storage = new SplObjectStorage;
    }
    public function publish($post)
    {
        $this->posts[] = $post;
        $this->notify();
    }
    public function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }
    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }
    public function notify()
    {
        foreach ($this->storage as $observer) {
            $observer->update($this);
        }
    }
}

class User implements SplObserver
{
    public function update(SplSubject $subject)
    {
        echo 'Nuevo post publicado, email enviado al usuario!' . PHP_EOL;
    }
}


$blog = new Blog;
$blog->attach(new User);
$blog->publish('Este es el nuevo post bla, bla.');
