using PlatformodePaymentIntegration.Contract.Request;
using PlatformodePaymentIntegration.Contract.Response;
using PlatformodePaymentIntegration.Extension;
using PlatformodePaymentIntegration.Settings;
using System.Text.Json;

namespace PlatformodePaymentIntegration;

public class AllTransactionApi
{
    private const string URL = "api/alltransaction";

    private readonly HttpClient _httpClient;
    private readonly ApiSettings _apiSettings;

    public AllTransactionApi()
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

        AllTransactionRequest allTransactionRequest = CreateRequestParameter(_apiSettings);

        var jsonRequest = JsonSerializer.Serialize(allTransactionRequest);

        var httpContent = new StringContent(jsonRequest, System.Text.Encoding.UTF8, "application/json");

        _httpClient.DefaultRequestHeaders.Authorization = new System.Net.Http.Headers.AuthenticationHeaderValue("Bearer", tokenResponse.data.token);

        var httpResponse = await _httpClient.PostAsync($"{_apiSettings.BaseAddress}{URL}", httpContent);

        return await httpResponse.Content.ReadAsStringAsync();
    }

    private AllTransactionRequest CreateRequestParameter(ApiSettings apiSettings)
    {
        AllTransactionRequest allTransactionRequest = new()
        {
            merchant_key = apiSettings.MerchantKey
        };

        return allTransactionRequest;
    }

    public async Task PrintAsync()
    {
        AllTransactionRequest allTransactionRequest = CreateRequestParameter(_apiSettings);

        var response = await GetAsync();

        Console.WriteLine();
        ConsoleExtensions.BoxedOutput("Endpoint Bilgileri");
        ConsoleExtensions.WriteLineWithSubTitle("Endpoint Adresi : ", _apiSettings.BaseAddress + URL);
        ConsoleExtensions.WriteLineWithSubTitle("Method Tipi : ", HttpMethod.Post);
        ConsoleExtensions.BoxedOutput("Request Parametreler");
        ConsoleExtensions.WriteLineWithSubTitle($"merchant_key : ", allTransactionRequest.merchant_key);
        ConsoleExtensions.BoxedOutput("Response Parametreler");
        ConsoleExtensions.WriteLineWithSubTitle("status_code", $"{response ?? "Response alınamadı."}");
    }
}
