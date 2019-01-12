package ep.rest

import java.io.Serializable
import java.util.*

data class Artikel(
        val idartikla: Int = 0,
        val naziv: String = "",
        val opis: String = "",
        val cena: Double = 0.0,
        val st_ocen: String = "",
        val povprecna_ocena: Double = 0.0,
        val status: Int = 0,
        val datspr: String,
        val idspr: Int
        ) : Serializable
