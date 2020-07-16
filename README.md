# BEST BUY REST API E-COMMERCE

## Description

This repository is a Software of Development with Laravel,JWT,MySQL,etc

## Installation

Using Laravel 7 and Vue.js 2 Server preferably.

## DataBase

Using MySQL preferably.
Create a MySQL database and configure the .env file.

## Apps

Using Postman, Insomnia,etc

## Usage

```html
$ git clone https://github.com/DanielArturoAlejoAlvarez/BEST-BUY-E-Commerce-Laravel-7-Rest-Api-JWT-Auth[NAME APP]

$ composer install

$ copy .env.example .env

$ php artisan key:generate

$ php artisan migrate:refresh --seed

$ php artisan serve

$ npm install (Frontend)

$ npm run dev

```

Follow the following steps and you're good to go! Important:

![alt text](https://raw.githubusercontent.com/onecentlin/laravel5-snippets-vscode/master/images/screenshot.gif)

## Coding

### Controllers

```php
...
class OrderController extends Controller
{
    private $order;

    function __construct(Order $order)
    {
      $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->orderBy('id','desc')->get();
        return response()->json(new OrderCollection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
      $order = $this->order->create($request->all());
      foreach ($request->order_items as $item) {
         $product = Product::find($item['product_id']);
         $order->order_items()->create([
           "product_id" =>  $product->id,
           'quantity'   =>  $item['quantity'],
           'price'      =>  $product->price
         ]);
         $currentStock = $product->stock - $item['quantity'];
         $product->update(['stock' => $currentStock]);
       }
      return response()->json(new OrderResource($order));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
      $order->update($request->all());
      foreach ($request->order_items as $key => $item) {
         $product = Product::find($item['product_id']);
         $order->order_items[$key]->update([
           "product_id" =>  $product->id,
           'quantity'   =>  $item['quantity'],
           'price'      =>  $product->price
         ]);
         $currentStock = $product->stock - $item['quantity'];
         $product->update(['stock' => $currentStock]);
       }
      return response()->json(new OrderResource($order));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
...
```

### Models

```php
...
class Order extends Model
{

  protected $fillable = [
    'user_id'
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function order_items() {
    return $this->hasMany(OrderItem::class);
  }

  public function products() {
    return $this->belongsToMany(Product::class, "order_items");
  }
}
...
```

### Resources

```php
...
public function toArray($request)
{    
  $total = 0;
  foreach ($this->order_items as $item) {
    $total += $item->price*$item->quantity;
  }

  return [
    'id'                =>    $this->id,
    'user_id'           =>    $this->user_id,
    'products_count'    =>    $this->products->count(),
    'products_count'    =>    $this->products->count(),
    'order_items_count' =>    $this->order_items->count(),
    'payment'           =>    round($total, 2),
    'products'          =>    ProductResource::collection($this->products),
    'order_items'       =>    OrderItemResource::collection($this->order_items),
    'published'         =>    $this->created_at->diffForHumans(),
    'created_at'        =>    $this->created_at->format('d-m-Y'),
    'updated_at'        =>    $this->updated_at->format('d-m-Y')
  ];
}

...
```

### Middlewares

```php
...
class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      try {
        $user = JWTAuth::parseToken()->authenticate();
      } catch (\Exception $e) {
        if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
          return response()->json(['status'=>'Token is Invalid!']);
        }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
          return response()->json(['status'=>'Token is Expired!']);
        }else {
          return response()->json(['status'=>'Authorization Token not found!']);
        }
      }

        return $next($request);
    }
}

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      header("Access-Control-Allow-Origin: *");

      // ALLOW OPTIONS METHOD
      $headers = [
          'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
          'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
      ];
      if($request->getMethod() == "OPTIONS") {
          // The client-side application can set only headers allowed in Access-Control-Allow-Headers
          return Response::make('OK', 200, $headers);
      }

      $response = $next($request);
      foreach($headers as $key => $value)
          $response->header($key, $value);
      return $response;
    }
}
...
```

### Routes
```php
...
Route::post('auth/login', 'Api\AuthController@login')->name('login');

Route::group(['middleware'=>['apiJwt']], function() {
  Route::apiResource('/categories','Api\CategoryController');
  Route::apiResource('/products','Api\ProductController');
  Route::apiResource('/orders','Api\OrderController');
  Route::apiResource('/users','Api\UserController');
  Route::apiResource('/order-items','Api\OrderItemController');
});

Route::get('/products', 'Api\ProductController@index');
...
```

### Factory
```php
...
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password');,
        'remember_token' => Str::random(10),
    ];
});
...
```

### Seeders
```php
...
class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $orders = Order::all();
        $products = Product::all()->toArray();

        foreach ($orders as $order) {
          $used = [];

          for ($i=0; $i < rand(1,5); $i++) {
            $product = $faker->randomElement($products);

            if(!in_array($product["id"],$used)) {
              $id = $product["id"];
              $price = $product["price"];
              $quantity = $faker->numberBetween(1,3);

              OrderItem::create([
                'order_id'  =>  $order->id,
                'product_id'=>  $id,
                'quantity'  =>  $quantity,
                'price'     =>  $price
              ]);

              $used[] = $product["id"];
            }
          }
        }
    }
}
...
```


## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/DanielArturoAlejoAlvarez/BEST-BUY-E-Commerce-Laravel-7-Rest-Api-JWT-Auth. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.

## License

The gem is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).

```

```
