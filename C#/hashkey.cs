

using System;
using System.Security.Cryptography;
using System.Text;
using System.Linq;

public class HashGenerator
{
    public string GenerateHashKey(string total, string installment, string currency_code, string merchant_key, string invoice_id, string app_secret)
    {
        string data = total + "|" + installment + "|" + currency_code + "|" + merchant_key + "|" + invoice_id;

        Random mt_rand = new Random();

        string iv = Sha1Hash(mt_rand.Next().ToString()).Substring(0, 16);

        string password = Sha1Hash(app_secret);

        string salt = Sha1Hash(mt_rand.Next().ToString()).Substring(0, 4);

        string saltWithPassword = "";

        using (SHA256 sha256Hash = SHA256.Create())
        {
            saltWithPassword = GetHash(sha256Hash, password + salt);
        }

        string encrypted = Encryptor(data, saltWithPassword.Substring(0, 32), iv);

        string msg_encrypted_bundle = iv + ":" + salt + ":" + encrypted;
        msg_encrypted_bundle = msg_encrypted_bundle.Replace("/", "__");

        return msg_encrypted_bundle;
    }

    
    private string GetHash(HashAlgorithm hashAlgorithm, string input)
    {
        byte[] data = hashAlgorithm.ComputeHash(Encoding.UTF8.GetBytes(input));
        var sBuilder = new StringBuilder();

        for (int i = 0; i < data.Length; i++)
        {
            sBuilder.Append(data[i].ToString("x2"));
        }

        return sBuilder.ToString();
    }

    private string Sha1Hash(string password)
    {
        return string.Join("", SHA1CryptoServiceProvider.Create().ComputeHash(Encoding.UTF8.GetBytes(password)).Select(x => x.ToString("x2")));
    }

    private string Encryptor(string TextToEncrypt, string strKey, string strIV)
    {
        byte[] PlainTextBytes = System.Text.Encoding.UTF8.GetBytes(TextToEncrypt);

        AesCryptoServiceProvider aesProvider = new AesCryptoServiceProvider();
        aesProvider.BlockSize = 128;
        aesProvider.KeySize = 256;
        aesProvider.Key = System.Text.Encoding.UTF8.GetBytes(strKey);
        aesProvider.IV = System.Text.Encoding.UTF8.GetBytes(strIV);
        aesProvider.Padding = PaddingMode.PKCS7;
        aesProvider.Mode = CipherMode.CBC;

        ICryptoTransform cryptoTransform = aesProvider.CreateEncryptor(aesProvider.Key, aesProvider.IV);
        byte[] EncryptedBytes = cryptoTransform.TransformFinalBlock(PlainTextBytes, 0, PlainTextBytes.Length);

        return Convert.ToBase64String(EncryptedBytes);
    }
    public static void Main(string[] args)
    {
        HashGenerator hashGenerator = new HashGenerator(); // HashGenerator sınıfından bir nesne oluşturun
    string hashKey = hashGenerator.GenerateHashKey("10", "1", "TRY", "$2y$10$w/ODdbTmfubcbUCUq/ia3OoJFMUmkM1UVNBiIQIuLfUlPmaLUT1he", "PAYBULL-INVOICE-2", "217071ea9f3f2e9b695d8f0039024e64");

    Console.WriteLine("Hash Key:"+ hashKey);
    }
}

