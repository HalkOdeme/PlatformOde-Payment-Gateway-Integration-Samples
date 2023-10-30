using System;
using System.Net.Http;
using System.Threading.Tasks;

class Program
{
    static async Task Main()
    {
        var client = new HttpClient();
        var url = "https://app.platformode.com.tr/ccpayment/api/paySmart2D"; // Yeni URL

        var request = new HttpRequestMessage(HttpMethod.Post, url);
        request.Headers.Add("Accept", "application/json");
        request.Headers.Add("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxNSIsImp0aSI6ImEyZTlkMzllYTcxMTRhMTE4..."); // Gerçek tokeninizle değiştirin

        var jsonContent = "{\r\n\"cc_holder_name\":\"Test kart\",\r\n\"cc_no\":\"4132260000000003\",\r\n\"expiry_month\":\"12\",\r\n\"expiry_year\":\"2024\",\r\n\"cvv\":\"555\",\r\n\"currency_code\":\"TRY\",\r\n\"installments_number\": 1,\r\n\"invoice_id\":\"s1211111111\",\r\n\"invoice_description\":\"INVOICE TEST DESCRIPTION\",\r\n\"total\":10,\r\n\"merchant_key\":\"$2y$10$HmRgYosneqcwHj.UH7upGuyCZqpQ1ITgSMj9Vvxn.t6f.Vdf2SQFO\",\r\n\"items\":[{\"name\":\"Item3\",\"price\":10,\"qnantity\":1,\"description\":\"item3 description\"}],\r\n\"name\" : \"John\",\r\n\"surname\" : \"Dao\",\r\n\"hash_key\" : \"4ceae33d55ce49f9:7800:WheFAz8QSZTZkA6kxHfpPpzLiSOG7RC8RZ4UZCpotgMUGXNQ4S7h48THDmNxN6fwzZzSeQ7Ps13whEIxoL7Z7LSz__shMHuaNBQWw72iyZZhW__PmrF7bB4j2qGg3C4Njcj1\"\r\n}";
        request.Content = new StringContent(jsonContent, System.Text.Encoding.UTF8, "application/json");

        var response = await client.SendAsync(request);

        if (response.IsSuccessStatusCode)
        {
            var responseContent = await response.Content.ReadAsStringAsync();
            Console.WriteLine(responseContent);
        }
        else
        {
            Console.WriteLine("HTTP isteği başarısız: " + response.StatusCode);
        }
    }
}
