package ep.rest

import android.app.AlertDialog
import android.content.Intent
import android.os.Bundle
import android.support.v7.app.AppCompatActivity
import android.util.Log
import kotlinx.android.synthetic.main.activity_book_detail.*
import kotlinx.android.synthetic.main.content_book_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ArtikelDetailActivity : AppCompatActivity(), Callback<Artikel> {

    private var artikel: Artikel? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_book_detail)
        setSupportActionBar(toolbar)

        fabEdit.setOnClickListener {
            val intent = Intent(this, ArtikelFormActivity::class.java)
            intent.putExtra("ep.rest.artikel", artikel)
            startActivity(intent)
        }

        fabDelete.setOnClickListener {
            val dialog = AlertDialog.Builder(this)
            dialog.setTitle("Confirm deletion")
            dialog.setMessage("Are you sure?")
            dialog.setPositiveButton("Yes") { _, _ -> deleteBook() }
            dialog.setNegativeButton("Cancel", null)
            dialog.create().show()
        }


        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val id = intent.getIntExtra("ep.rest.id", 0)
        System.err.println("ID: " + id)
        if (id > 0) {
            ArtikelService.instance.get("$id").enqueue(this)
        }
    }

    private fun deleteBook() {
        // todo
    }

    override fun onResponse(call: Call<Artikel>, response: Response<Artikel>) {
        artikel = response.body()
        Log.i(TAG, "Got result: $artikel")

        if (response.isSuccessful) {
            //tvBookPrice.text = artikel?.cena.toString()
            tvBookDetail.text = "Cena: " + artikel?.cena.toString() + " €\n\n" +
                    "Povprečna ocena: " + artikel?.povprecna_ocena.toString() + "\n\n" +
                    "Število ocen: " + artikel?.st_ocen.toString() + "\n\n" +
                    "Opis: " + artikel?.opis
            toolbarLayout.title = artikel?.naziv
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody().string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Log.e(TAG, errorMessage)
            tvBookDetail.text = errorMessage
        }
    }

    override fun onFailure(call: Call<Artikel>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
    }

    companion object {
        private val TAG = ArtikelDetailActivity::class.java.canonicalName
    }
}
