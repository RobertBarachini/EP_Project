package ep.rest

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

object ArtikelService {

    interface RestApi {

        companion object {
            const val URL = "http://10.0.2.2/api/v1/"
        }

        @GET("artikli/read.php")
        fun getAll(): Call<ArtikelWrapper>

        @GET("artikli/read_one.php")
        fun get(@Query("id") id: String): Call<Artikel>
    }

    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}
