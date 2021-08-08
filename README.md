HandleInertiaRequests.php ->

```
public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'laravel-tarva' => fn () => $request->session()->get('laravel-tarva')
            ]
        ]);
    }
```

custom css for wysiwyg :

```
[data-prosemirror="my-field"]
```
