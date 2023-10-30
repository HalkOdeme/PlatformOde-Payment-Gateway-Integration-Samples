using RestSharp; // RestSharp kütüphanesini projenize eklediğinizden emin olun

var baseUrl = "https://app.platformode.com.tr/ccpayment/api/paySmart3D";

var client = new RestClient(baseUrl);

var request = new RestRequest("", Method.POST); // Boş bir path kullanıyoruz, çünkü "baseUrl" zaten yolun başlangıcıdır

request.AddHeader("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxNSIsImp0aSI6ImEyZTlkMzllYT71YyNPI6NQAj3KxOX");

// Diğer parametreleri ekleyin
request.AddParameter("cc_holder_name", "asddasddddd");
request.AddParameter("cc_no", "4132260000000003");
request.AddParameter("expiry_month", "12");
request.AddParameter("expiry_year", "2024");
request.AddParameter("currency_code", "TRY");
request.AddParameter("installments_number", "1");
request.AddParameter("invoice_id", "03b9659f-03f4-48af-ad9d-b42e8c11407d");
request.AddParameter("invoice_description", "ewrwer");
request.AddParameter("total", "125");
request.AddParameter("merchant_key", "$2y$10$w/ODdbTmfubcbUCUq/ia3OoJFMUmkM1UVNBiIQIuLfUlPmaLUT1he");

// JSON dizisi eklemek için
string itemsJson = "[{\"name\":\"Item3\",\"price\":125.00,\"quantity\":1,\"description\":\"item3 description\"}]";
request.AddParameter("items", itemsJson, ParameterType.RequestBody);

request.AddParameter("name", "John");
request.AddParameter("surname", "Dao");
request.AddParameter("hash_key", "17a800423ccdeab5:6541:dl5CJlHN9ElmApnqUw9t1KEjTVoJgO8DJUm9qDqf557tkO2B0cqMMgEI9ke9eHCjHhoEIbJD+2e8T2YefjwfJ82zUhNP9ofXYDFSMXYz95J1tyhxNYuT0EUjzhr6oWlrT__t3TAb05O6exZ+rSk4tPQ==");
request.AddParameter("return_url", "http://merchant-domain.com?success.php");
request.AddParameter("cancel_url", "http://merchant-domain.com?fail.php");

var response = client.Execute(request);
Console.WriteLine(response.Content);
