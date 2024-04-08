using PlatformodePaymentIntegration.Contract.Request;
using PlatformodePaymentIntegration.Contract.Response;
using PlatformodePaymentIntegration.Extension;
using PlatformodePaymentIntegration.Generate;
using PlatformodePaymentIntegration.Settings;
using System.Text.Json;

namespace PlatformodePaymentIntegration;

public class PaySmart3D
{
    private const string URL = "api/paySmart3D";

    private readonly HttpClient _httpClient;
    private readonly ApiSettings _apiSettings;

    public PaySmart3D()
    {
        _httpClient = new HttpClient();
        _apiSettings = new ApiSettingConfiguration().Configuration();
    }

    private async Task<string?> GetAsync()
    {
        var tokenResponse = await new TokenApi().GetAsync();

        if (tokenResponse == null)
        {
            throw new ArgumentNullException("Token bilgisi alınamadı. Lütfen appsettings.json dosyasındaki bilgileri kontrol ediniz.");
        }

        PaySmart3DRequest paySmart3DRequest = CreateRequestParameter(_apiSettings);

        var jsonRequest = JsonSerializer.Serialize(paySmart3DRequest);

        var httpContent = new StringContent(jsonRequest, System.Text.Encoding.UTF8, "application/json");

        _httpClient.DefaultRequestHeaders.Authorization = new System.Net.Http.Headers.AuthenticationHeaderValue("Bearer", tokenResponse.data.token);

        var httpResponse = await _httpClient.PostAsync($"{_apiSettings.BaseAddress}{URL}", httpContent);

        return await httpResponse.Content.ReadAsStringAsync();
    }

    private PaySmart3DRequest CreateRequestParameter(ApiSettings apiSettings)
    {
        PaySmart3DRequest paySmart3DRequest = new()
        {
            cc_holder_name = "Test kart",
            cc_no = "4132260000000003",
            expiry_month = "11",
            expiry_year = "2027",
            currency_code = "TRY",
            installments_number = 1,
            invoice_id = InvoiceGenerator.GenerateInvoiceId(),
            invoice_description = "INVOICE TEST DESCRIPTION",
            total = 10,
            items = new List<Item3D>
            {
                new Item3D()
                {
                    name = "item",
                    price = 10,
                    quantity = 1,
                    description = "item description"
                }
            },
            name = "John",
            surname = "Dao",
            return_url = "https://www.google.com/",
            cancel_url = "https://www.github.com/",
            payment_completed_by = "merchant",    // optional
            cvv = "555",  // optional
            merchant_key = apiSettings.MerchantKey
        };

        HashGenerator hashGenerator = new HashGenerator();

        paySmart3DRequest.hash_key = hashGenerator.GenerateHashKey(
            false,
            paySmart3DRequest.total.ToString()?.Replace(",", ".") ?? "",
            paySmart3DRequest.installments_number.ToString(),
            paySmart3DRequest.currency_code,
            paySmart3DRequest.merchant_key,
            paySmart3DRequest.invoice_id);

        return paySmart3DRequest;
    }

    public async Task PrintAsync()
    {
        PaySmart3DRequest paySmart3DRequest = CreateRequestParameter(_apiSettings);

        var response = await GetAsync();

        Console.WriteLine();
        ConsoleExtensions.BoxedOutput("Endpoint Bilgileri");
        ConsoleExtensions.WriteLineWithSubTitle("Endpoint Adresi : ", _apiSettings.BaseAddress + URL);
        ConsoleExtensions.WriteLineWithSubTitle("Method Tipi : ", HttpMethod.Post);
        ConsoleExtensions.BoxedOutput("Request Parametreler");
        ConsoleExtensions.WriteLineWithSubTitle($"cc_holder_name : ", paySmart3DRequest.cc_holder_name);
        ConsoleExtensions.WriteLineWithSubTitle($"cc_no : ", paySmart3DRequest.cc_no);
        ConsoleExtensions.WriteLineWithSubTitle($"expiry_month : ", paySmart3DRequest.expiry_month);
        ConsoleExtensions.WriteLineWithSubTitle($"expiry_year : ", paySmart3DRequest.expiry_year);
        ConsoleExtensions.WriteLineWithSubTitle($"currency_code : ", paySmart3DRequest.currency_code);
        ConsoleExtensions.WriteLineWithSubTitle($"installments_number : ", paySmart3DRequest.installments_number);
        ConsoleExtensions.WriteLineWithSubTitle($"invoice_id : ", paySmart3DRequest.invoice_id);
        ConsoleExtensions.WriteLineWithSubTitle($"invoice_description : ", paySmart3DRequest.invoice_description);
        ConsoleExtensions.WriteLineWithSubTitle($"total : ", paySmart3DRequest.total);
        ConsoleExtensions.WriteLineWithSubTitle($"items : ",JsonSerializer.Serialize(paySmart3DRequest.items));
        ConsoleExtensions.WriteLineWithSubTitle($"name : ", paySmart3DRequest.name);
        ConsoleExtensions.WriteLineWithSubTitle($"surname : ", paySmart3DRequest.surname);
        ConsoleExtensions.WriteLineWithSubTitle($"return_url : ", paySmart3DRequest.return_url);
        ConsoleExtensions.WriteLineWithSubTitle($"cancel_url : ", paySmart3DRequest.cancel_url);
        ConsoleExtensions.WriteLineWithSubTitle($"payment_completed_by : ", paySmart3DRequest.payment_completed_by);  // Optional
        ConsoleExtensions.WriteLineWithSubTitle($"cvv : ", paySmart3DRequest.cvv);    // Optional
        ConsoleExtensions.WriteLineWithSubTitle($"merchant_key : ", paySmart3DRequest.merchant_key);
        ConsoleExtensions.WriteLineWithSubTitle($"hash_key : ", paySmart3DRequest.hash_key);
        ConsoleExtensions.BoxedOutput("Response Parametreler");
        ConsoleExtensions.WriteLineWithSubTitle("response : ",response ?? "Response alınamadı.");
    }
}
