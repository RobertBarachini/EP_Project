package ep.rest

import java.io.Serializable
import java.util.*

data class ArtikelWrapper(
        val count: Int = 0,
        val body: List<Artikel>
        ) : Serializable
