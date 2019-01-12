package ep.rest

import android.content.Intent
import android.os.Bundle
import android.support.v7.app.AppCompatActivity
import android.util.Log
import android.widget.AdapterView
import android.widget.Toast
import kotlinx.android.synthetic.main.activity_main.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class MainActivity : AppCompatActivity(), Callback<ArtikelWrapper> {

    private var adapter: ArtikelAdapter? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        adapter = ArtikelAdapter(this)
        items.adapter = adapter
        items.onItemClickListener = AdapterView.OnItemClickListener { _, _, i, _ ->
            val book = adapter?.getItem(i)
            if (book != null) {
                System.err.println("Book: " + book.idartikla)
                val intent = Intent(this, ArtikelDetailActivity::class.java)
                intent.putExtra("ep.rest.id", book.idartikla)
                startActivity(intent)
            }
        }

        container.setOnRefreshListener { ArtikelService.instance.getAll().enqueue(this) }

        btnSave.setOnClickListener {
            val intent = Intent(this, ArtikelFormActivity::class.java)
            startActivity(intent)
        }

        ArtikelService.instance.getAll().enqueue(this)
    }

    override fun onResponse(call: Call<ArtikelWrapper>, response: Response<ArtikelWrapper>) {
        val hits = response.body()
        val articles = hits as ArtikelWrapper

        if (response.isSuccessful) {
            Log.i(TAG, "Hits: " + articles.count)
            adapter?.clear()
            adapter?.addAll(articles.body)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody().string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show()
            Log.e(TAG, errorMessage)
        }
        container.isRefreshing = false
    }

    override fun onFailure(call: Call<ArtikelWrapper>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
        container.isRefreshing = false
    }

    companion object {
        private val TAG = MainActivity::class.java.canonicalName
    }
}
