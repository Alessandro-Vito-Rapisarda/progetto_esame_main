<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdottoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categorie
        $categorie = [
            ['id' => 1, 'nome' => 'Smartphone', 'descrizione' => 'iPhone e dispositivi mobili'],
            ['id' => 2, 'nome' => 'Computer', 'descrizione' => 'MacBook e desktop Mac'],
            ['id' => 3, 'nome' => 'Tablet', 'descrizione' => 'iPad Pro, Air, mini e base'],
            ['id' => 4, 'nome' => 'Audio', 'descrizione' => 'AirPods, cuffie e accessori sonori'],
        ];

        foreach ($categorie as $cat) {
            DB::table('categorie')->updateOrInsert(['id' => $cat['id']], $cat);
        }

        // 2. Prodotti
        $prodotti = [
            [
                'id' => 1,
                'nome' => 'iPhone 17 Pro',
                'descrizione' => 'Display Super Retina XDR con tecnologia ProMotion. Chip A19 Pro per prestazioni mai viste.',
                'prezzo' => 1349.00,
                'quantita_disponibile' => 20,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone17pro.jpg',
            ],
            [
                'id' => 2,
                'nome' => 'iPhone 17 Air',
                'descrizione' => 'Design ultrasottile, display OLED edge-to-edge e prestazioni eccezionali con Apple Intelligence.',
                'prezzo' => 1129.00,
                'quantita_disponibile' => 15,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone17air.png',
            ],
            [
                'id' => 3,
                'nome' => 'iPhone 17',
                'descrizione' => 'Chip A19 di ultima generazione, sistema a doppia fotocamera avanzata e autonomia per tutto il giorno.',
                'prezzo' => 979.00,
                'quantita_disponibile' => 25,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone17.jpeg',
            ],
            [
                'id' => 4,
                'nome' => 'iPhone 14 Pro Max',
                'descrizione' => 'Dynamic Island, display da 6,7 pollici, fotocamera principale da 48MP e chip A16 Bionic.',
                'prezzo' => 1099.00,
                'quantita_disponibile' => 12,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone14promax.jpeg',
            ],
            [
                'id' => 5,
                'nome' => 'iPhone 14 Pro',
                'descrizione' => 'Dynamic Island, fotocamera da 48MP con dettagli strabilianti e chip A16 Bionic ultra-reattivo.',
                'prezzo' => 949.00,
                'quantita_disponibile' => 10,
                'categoria_id' => 1,
                'immagine_url' => 'img/Iphone14pro.jpg',
            ],
            [
                'id' => 6,
                'nome' => 'iPhone 14',
                'descrizione' => 'Display Super Retina XDR da 6,1", modalita Azione per video stabili e rilevamento incidenti.',
                'prezzo' => 799.00,
                'quantita_disponibile' => 18,
                'categoria_id' => 1,
                'immagine_url' => 'img/Iphone14.jpg',
            ],
            [
                'id' => 7,
                'nome' => 'iPhone 13',
                'descrizione' => 'Sistema a doppia fotocamera evoluto, chip A15 Bionic e durata della batteria potenziata.',
                'prezzo' => 629.00,
                'quantita_disponibile' => 22,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone13.jpg',
            ],
            [
                'id' => 8,
                'nome' => 'iPhone 13 mini',
                'descrizione' => 'Tutta la potenza di iPhone 13 in un formato compatto tascabile da 5,4 pollici.',
                'prezzo' => 549.00,
                'quantita_disponibile' => 8,
                'categoria_id' => 1,
                'immagine_url' => 'img/iphone13mini.jpeg',
            ],
            [
                'id' => 9,
                'nome' => 'iPhone SE',
                'descrizione' => 'Design classico, Touch ID sicuro, chip potente e fotocamera intelligente con Smart HDR.',
                'prezzo' => 499.00,
                'quantita_disponibile' => 14,
                'categoria_id' => 1,
                'immagine_url' => 'img/IphoneSE.jpeg',
            ],
            [
                'id' => 10,
                'nome' => 'MacBook Pro 16"',
                'descrizione' => 'Il laptop professionale definitivo: display Liquid Retina XDR da 16 pollici e chip Apple Silicon.',
                'prezzo' => 2899.00,
                'quantita_disponibile' => 7,
                'categoria_id' => 2,
                'immagine_url' => 'img/macbookpro16.jpeg',
            ],
            [
                'id' => 11,
                'nome' => 'MacBook Pro 14"',
                'descrizione' => 'Potenza estrema e portabilita professionale con display Liquid Retina XDR da 14 pollici.',
                'prezzo' => 2199.00,
                'quantita_disponibile' => 9,
                'categoria_id' => 2,
                'immagine_url' => 'img/macbookpro14.jpg',
            ],
            [
                'id' => 12,
                'nome' => 'MacBook Pro 13"',
                'descrizione' => 'Raffreddamento attivo per prestazioni elevate costanti, Magic Keyboard e autonomia fino a 20 ore.',
                'prezzo' => 1499.00,
                'quantita_disponibile' => 11,
                'categoria_id' => 2,
                'immagine_url' => 'img/macbookpro13.jpeg',
            ],
            [
                'id' => 13,
                'nome' => 'MacBook Air M2',
                'descrizione' => 'Design incredibilmente sottile, display Liquid Retina da 13,6" e chip M2 di nuova generazione.',
                'prezzo' => 1199.00,
                'quantita_disponibile' => 16,
                'categoria_id' => 2,
                'immagine_url' => 'img/macbookairM2.jpeg',
            ],
            [
                'id' => 14,
                'nome' => 'MacBook Air M1',
                'descrizione' => 'Il Mac piu amato, potente e silenzioso grazie all architettura fanless del chip M1.',
                'prezzo' => 949.00,
                'quantita_disponibile' => 20,
                'categoria_id' => 2,
                'immagine_url' => 'img/macbookairM1.jpeg',
            ],
            [
                'id' => 15,
                'nome' => 'iPad Pro',
                'descrizione' => 'Display Ultra Retina XDR Tandem OLED, chip M4 ultra-veloce e supporto ad Apple Pencil Pro.',
                'prezzo' => 1219.00,
                'quantita_disponibile' => 10,
                'categoria_id' => 3,
                'immagine_url' => 'img/ipadpro.jpeg',
            ],
            [
                'id' => 16,
                'nome' => 'iPad Air',
                'descrizione' => 'Prestazioni rivoluzionarie con il chip M2, fotocamera orizzontale e splendidi colori.',
                'prezzo' => 719.00,
                'quantita_disponibile' => 18,
                'categoria_id' => 3,
                'immagine_url' => 'img/ipadair.jpeg',
            ],
            [
                'id' => 17,
                'nome' => 'iPad mini',
                'descrizione' => 'Design compatto all-screen da 8,3 pollici, chip A17 Pro e compatibilita Apple Pencil Pro.',
                'prezzo' => 609.00,
                'quantita_disponibile' => 13,
                'categoria_id' => 3,
                'immagine_url' => 'img/ipadmini.jpeg',
            ],
            [
                'id' => 18,
                'nome' => 'iPad 10a generazione',
                'descrizione' => 'Display Liquid Retina da 10,9 pollici, connessione USB-C e fotocamere evolute per studio e lavoro.',
                'prezzo' => 409.00,
                'quantita_disponibile' => 25,
                'categoria_id' => 3,
                'immagine_url' => 'img/ipad.jpeg',
            ],
            [
                'id' => 19,
                'nome' => 'AirPods Max',
                'descrizione' => 'Cuffie over-ear ad alta fedelta con cancellazione attiva del rumore e audio spaziale personalizzato.',
                'prezzo' => 579.00,
                'quantita_disponibile' => 14,
                'categoria_id' => 4,
                'immagine_url' => 'img/airpodsmax.png',
            ],
            [
                'id' => 20,
                'nome' => 'AirPods Pro 2',
                'descrizione' => 'Cancellazione attiva del rumore fino a 2 volte piu efficace, audio adattivo e custodia MagSafe USB-C.',
                'prezzo' => 279.00,
                'quantita_disponibile' => 30,
                'categoria_id' => 4,
                'immagine_url' => 'img/airpods3pro.png',
            ],
            [
                'id' => 21,
                'nome' => 'AirPods 4',
                'descrizione' => 'Design riprogettato per un comfort superiore, isolamento vocale e audio spaziale tridimensionale.',
                'prezzo' => 149.00,
                'quantita_disponibile' => 35,
                'categoria_id' => 4,
                'immagine_url' => 'img/airpods4.png',
            ],
        ];

        foreach ($prodotti as $p) {
            DB::table('prodotti')->updateOrInsert(['id' => $p['id']], $p);

            // Immagine collegata
            DB::table('immagini_prodotti')->updateOrInsert(
                ['prodotto_id' => $p['id'], 'url' => $p['immagine_url']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
