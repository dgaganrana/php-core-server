## Request Flow

The lifecycle of a request in **php-core-server**:

1️⃣ **Browser / Client Request**  
- A user visits `http://localhost:8000/` or calls an API endpoint.  
- The request is routed through `public/index.php`.

2️⃣ **Router Dispatch**  
- `Router.php` reads the request path and method.  
- It matches against routes defined in `config/routes.php`.  
- The router decides which controller method to call.

3️⃣ **Controller Execution**  
- Example: `HomeController@index` or `HealthController@check`.  
- Controllers handle request logic and may call services for business rules.

4️⃣ **Service Layer (Optional)**  
- Services like `HealthService.php` encapsulate reusable business logic.  
- Controllers delegate complex operations here.

5️⃣ **Response Creation**  
- Controllers return an `App\Http\Response` object.  
- Response includes status code, headers, and body (HTML or JSON).

6️⃣ **Output to Client**  
- The response is sent back to the browser or API client.  
- For web routes → HTML page (`public/homePage.php`).  
- For API routes → JSON payload.

---

### Example: Home Page Request
- **Request:** `GET /`  
- **Flow:**  
  - `public/index.php` → `Router.php` → `HomeController@index`  
  - Returns `Response(200, [], 'Welcome to HomePage')`  
  - Browser displays the homepage content.

### Example: Health API Request
- **Request:** `GET /api/health`  
- **Flow:**  
  - `public/index.php` → `Router.php` → `HealthController@check` → `HealthService`  
  - Returns `Response(200, [], '{"status":"ok"}')`  
  - API client receives JSON response.
