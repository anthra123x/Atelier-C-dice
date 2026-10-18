<?php

namespace Database\Seeders;

use App\Models\AudioTrack;
use App\Models\Board;
use App\Models\CanvasConnection;
use App\Models\CanvasNode;
use App\Models\Character;
use App\Models\Collaborator;
use App\Models\LibraryItem;
use App\Models\Location;
use App\Models\Universe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        $user = User::query()->firstOrCreate(
            ['email' => 'admin@codice.local'],
            [
                'name' => 'Arquitecto de Mundos',
                'password' => Hash::make('password123'),
            ]
        );

        // 1. Primary Universe
        $universe = Universe::query()->firstOrCreate(
            ['slug' => 'cronicas-de-neo-kyoto'],
            [
                'title' => 'Crónicas de Neo-Kyoto',
                'tagline' => 'Un compendio ciberpunk narrativo y cartografía de facciones interconectadas.',
                'description' => 'Neo-Kyoto, año 2094. Las megacorporaciones controlan las redes de memoria sintética mientras facciones disidentes conspiran en los muelles y callejones inundados del Distrito 4.',
                'settings' => [
                    'theme' => 'Estudio Códice',
                    'font_headline' => 'Newsreader',
                    'font_body' => 'Inter',
                    'font_label' => 'Plus Jakarta Sans',
                    'primary_color' => '#3525cd',
                    'accent_terracotta' => '#EA580C',
                    'accent_sage' => '#10B981',
                    'accent_amber' => '#F59E0B',
                ],
            ]
        );

        // 2. Collaborators
        $collaboratorsData = [
            ['name' => 'Aura', 'initials' => 'AU', 'role' => 'Editando', 'color' => '#EA580C', 'avatar_url' => null, 'is_online' => true],
            ['name' => 'Ren', 'initials' => 'RN', 'role' => 'Viendo', 'color' => '#10B981', 'avatar_url' => null, 'is_online' => true],
            ['name' => 'Maya', 'initials' => 'MY', 'role' => 'Comentando', 'color' => '#F59E0B', 'avatar_url' => null, 'is_online' => true],
        ];

        foreach ($collaboratorsData as $collab) {
            Collaborator::query()->firstOrCreate(
                ['universe_id' => $universe->id, 'initials' => $collab['initials']],
                $collab
            );
        }

        // 3. Audio Tracks
        $ambientTrack = AudioTrack::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Noir Rain'],
            [
                'artist' => 'Kowloon Echoes',
                'category' => 'Ambient Loop',
                'duration' => '03:45',
                'audio_url' => 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=rain-and-nostalgia-ambient-112959.mp3',
                'waveform' => [4, 8, 12, 10, 6, 14, 11, 7, 12, 8, 14, 6, 10, 12, 4, 8, 14, 10, 6, 12, 8, 14, 6, 10, 14, 10, 4, 12, 6, 10, 14, 8],
                'is_loop' => true,
            ]
        );

        $masterTrack = AudioTrack::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Atmósfera de Escritura: Lluvia y Neón'],
            [
                'artist' => 'Kowloon Echoes',
                'category' => 'Dark Ambient & Procedural Rain Loops',
                'duration' => '1:15:00',
                'audio_url' => 'https://cdn.pixabay.com/download/audio/2022/01/18/audio_d0a13f69d2.mp3?filename=ambient-soundscape-4011.mp3',
                'waveform' => [6, 10, 12, 8, 4, 14, 10, 6, 12, 8, 14, 6, 10, 12, 4, 8, 14, 10, 6, 12, 8, 2, 10, 14, 6, 12, 8, 4, 12, 14, 10, 6, 12, 8, 2, 12, 6, 10, 14, 8],
                'is_loop' => true,
            ]
        );

        AudioTrack::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Pulsos de Neón en Sector 03'],
            [
                'artist' => 'Neural Syndicate',
                'category' => 'Synthwave & Drone',
                'duration' => '05:12',
                'audio_url' => null,
                'waveform' => [8, 12, 14, 10, 12, 8, 6, 14, 10, 8, 12, 6, 14, 8, 10, 14],
                'is_loop' => false,
            ]
        );

        // 4. Locations
        $locAlmacen = Location::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => '#01'],
            [
                'name' => 'Almacén 17 · Muelle Este',
                'sector' => 'Sector 04 · Hangares y Contrabando',
                'icon' => 'warehouse',
                'color' => '#EA580C',
                'map_x' => 610,
                'map_y' => 420,
                'status' => 'Bajo Sospecha',
                'threat_level' => 4,
                'description' => 'Antiguo hangar portuario reconvertido en punto de transferencia para cargamentos biotecnológicos no declarados.',
                'intel' => 'Se reportan contenedores criogénicos con el sello de Industrias Kurogane.',
                'key_contacts' => ['Capataz Miller', 'El Sueco'],
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw',
            ]
        );

        $locCuervo = Location::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => '#02'],
            [
                'name' => 'Bar El Cuervo Eléctrico',
                'sector' => 'Sector 03 · Bazares y Tráfico',
                'icon' => 'local_bar',
                'color' => '#4F46E5',
                'map_x' => 320,
                'map_y' => 230,
                'status' => 'Zona Gris',
                'threat_level' => 2,
                'description' => 'Santuario de corredores de datos, mercenarios y analistas retirados. Las paredes están blindadas contra escaneos EMP.',
                'intel' => 'Las mesas del sótano cuentan con terminales de fibra óptica no rastreables.',
                'key_contacts' => ['Soran Kurogane', 'Kaelen Vance'],
                'image_url' => null,
            ]
        );

        Location::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => '#03'],
            [
                'name' => 'Archivo General de la Ciudad',
                'sector' => 'Sector 02 · Alta Jerarquía',
                'icon' => 'account_balance',
                'color' => '#10B981',
                'map_x' => 710,
                'map_y' => 160,
                'status' => 'Restringido',
                'threat_level' => 3,
                'description' => 'Monumento arquitectónico de concreto brutalista que alberga los servidores físicos pre-colapso.',
                'intel' => 'Requiere credenciales biométricas de clase Alfa para acceder al sótano 4.',
                'key_contacts' => ['Dra. Valeria Ruiz'],
                'image_url' => null,
            ]
        );

        Location::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => '#04'],
            [
                'name' => 'Puesto de Vigilancia Norte',
                'sector' => 'Sector 01 · Perímetro Militar',
                'icon' => 'visibility',
                'color' => '#F59E0B',
                'map_x' => 1080,
                'map_y' => 200,
                'status' => 'Alerta Máxima',
                'threat_level' => 5,
                'description' => 'Torre de control perimetral armada con cañones sónicos y antenas de intercepción espectral.',
                'intel' => 'Los drones de patrulla se recargan cada 45 minutos.',
                'key_contacts' => ['Comandante Vane'],
                'image_url' => null,
            ]
        );

        // 5. Characters
        Character::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => 'NEO-0924'],
            [
                'name' => 'Kaelen Vance',
                'role' => 'Detective Privado / Ex-Operativo',
                'status' => 'Pragmático · Insomne',
                'quote' => 'La verdad es un lujo que pocas calles de esta ciudad pueden costear.',
                'bio' => 'Veterano de la división táctica de Neo-Kyoto. Tras perder a su escuadrón en la purga del Distrito 4, opera como investigador independiente especializado en desapariciones corporativas y mercado negro de implantes.',
                'portrait_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw',
                'gallery_urls' => [
                    'https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw',
                ],
                'traits' => ['Pragmático', 'Insomne', 'Implante Óptico Mk.IV', 'Tirador Certero'],
                'palette' => ['#1E1B4B', '#4F46E5', '#EA580C', '#94A3B8', '#F1F5F9'],
                'location_id' => $locAlmacen->id,
                'audio_track_id' => $ambientTrack->id,
            ]
        );

        Character::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'code' => 'NEO-1102'],
            [
                'name' => 'Dra. Valeria Ruiz',
                'role' => 'Neurobióloga & Enlace Rebelde',
                'status' => 'Aliada Clave',
                'quote' => 'No modificamos la mente para escapar, sino para recordar quiénes éramos.',
                'bio' => 'Científica desertora del conglomerado NeuroSyn. Lidera una red clandestina de apoyo a ciudadanos cuyos implantes neuronales han sido saboteados por obsolescencia programada.',
                'portrait_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAljGYHMONMxWNipH13T50lqEoce-HcjxJJ2bl4kHaRULz6RH1XoMiGmcAqcCKnEfbdCG7bH76HCaleD277A5zBe_NVCK9BAtzlyGwOM1SrKcoeVnPkxhEdvYKXEg4aXkc4dAx8jNIxiGOjeHszPok-aU_EXHf4ZOOEwlAVWBY1yYSM7PP6y4Z7qh06RTz-S7EbX83msgcq8CAlvmO3E3RWrayZwmvutxyXEDZJnaOLd4HTfGhXTECavA',
                'gallery_urls' => [
                    'https://lh3.googleusercontent.com/aida-public/AB6AXuAljGYHMONMxWNipH13T50lqEoce-HcjxJJ2bl4kHaRULz6RH1XoMiGmcAqcCKnEfbdCG7bH76HCaleD277A5zBe_NVCK9BAtzlyGwOM1SrKcoeVnPkxhEdvYKXEg4aXkc4dAx8jNIxiGOjeHszPok-aU_EXHf4ZOOEwlAVWBY1yYSM7PP6y4Z7qh06RTz-S7EbX83msgcq8CAlvmO3E3RWrayZwmvutxyXEDZJnaOLd4HTfGhXTECavA',
                    'https://lh3.googleusercontent.com/aida-public/AB6AXuDnB4Lmp4oWZbH6Vjn_Wy9iXsLLrdgK09DWtXaoeIZxfsf6SJuHVS249t8rfB1aPBweNFGowuxZe66suor2MgmPfJsarZjrzMDPgwR9GamOZY_4Q20IMuLSA9EguUagPcXZKS_VPzGA6Q57hyok0mPPcAW2S6gwVKKHN4VdRo_ZwWmFy5Q0p0L0uTcrGDNDCxPWtHHF0RLA-MdY9kW0CfdCpFcrMZ_Z-M4EdrE8tQIcM-eUMbCPeB4MaA',
                    'https://lh3.googleusercontent.com/aida-public/AB6AXuDJQ6Yh_jZ7L78J8CiIOLy33-kNDGf73M3FleeAQN9-oqHEDYvmtdT0DbXTDx_cdJdbJGKl0AkMwTVw-YSI8P4Ry5cfvVY2LbVCTTDdCR-GvFjek5L8tjI94jDKqKDZAHTb5s2JamF09fsHMYztqAhUMbGQz3Q1SlQPm133PkcwjbVULa8ySLTd_kp1MmxFwwASdA2OF5Vo-5JLFHmrKENBy-sCBi0Ai5_wzBXjtBMAA5rYxsPvrud0ww',
                ],
                'traits' => ['Científica Visionaria', 'Resistencia Clandestina', 'Biohacking Avanzado', 'Mente Fría'],
                'palette' => ['#FFFFFF', '#10B981', '#334155', '#0F172A', '#6EE7B7'],
                'location_id' => $locCuervo->id,
                'audio_track_id' => $masterTrack->id,
            ]
        );

        // 6. Board & Nodes
        $board = Board::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'slug' => 'tablero-principal'],
            [
                'title' => 'Tablero Principal',
                'act' => 'Acto I: Sombras en el Distrito 4',
                'is_active' => true,
                'grid_snap_size' => 24,
                'zoom_level' => 100,
            ]
        );

        // Node 1: Character Dossier
        $node1 = CanvasNode::query()->firstOrCreate(
            ['board_id' => $board->id, 'title' => 'Kaelen Vance - Ficha'],
            [
                'type' => 'character',
                'pos_x' => 16,
                'pos_y' => 40,
                'width' => 360,
                'height' => 520,
                'is_pinned' => true,
                'data' => [
                    'id_badge' => 'ID: NEO-0924',
                    'name' => 'Kaelen Vance',
                    'category' => 'Ficha Narrativa',
                    'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw',
                    'quote' => 'La verdad es un lujo que pocas calles de esta ciudad pueden costear.',
                    'traits' => ['Pragmático', 'Insomne', 'Implante Óptico Mk.IV'],
                    'palette' => ['#1E1B4B', '#4F46E5', '#EA580C', '#94A3B8', '#F1F5F9'],
                    'audio_name' => 'Noir Rain',
                    'audio_duration' => '03:45',
                ],
            ]
        );

        // Node 2: Map Location Node
        $node2 = CanvasNode::query()->firstOrCreate(
            ['board_id' => $board->id, 'title' => 'Almacén 17 · Muelle Este'],
            [
                'type' => 'location',
                'pos_x' => 460,
                'pos_y' => 50,
                'width' => 360,
                'height' => 320,
                'is_pinned' => false,
                'data' => [
                    'code' => '#01',
                    'name' => 'Almacén 17 · Muelle Este',
                    'sector' => 'Sector 04 · Hangares y Contrabando',
                    'threat' => 'Nivel 4 · Alto',
                    'intel' => 'Punto de descarga clandestina de chips de memoria neural.',
                    'status' => 'Bajo Sospecha',
                ],
            ]
        );

        // Node 3: Audio Snippet Node
        $node3 = CanvasNode::query()->firstOrCreate(
            ['board_id' => $board->id, 'title' => 'Música Ambiental - Loop'],
            [
                'type' => 'audio',
                'pos_x' => 16,
                'pos_y' => 590,
                'width' => 360,
                'height' => 180,
                'is_pinned' => false,
                'data' => [
                    'track' => 'Atmósfera de Escritura: Lluvia y Neón',
                    'artist' => 'Kowloon Echoes',
                    'category' => 'Dark Ambient & Procedural Rain',
                    'duration' => '1:15:00',
                ],
            ]
        );

        // Node 4: Lore Note Node
        $node4 = CanvasNode::query()->firstOrCreate(
            ['board_id' => $board->id, 'title' => 'Nota de Campo: La Caída del Distrito 4'],
            [
                'type' => 'note',
                'pos_x' => 460,
                'pos_y' => 410,
                'width' => 360,
                'height' => 260,
                'is_pinned' => false,
                'data' => [
                    'category' => 'Nota Editorial',
                    'author' => 'Kaelen Vance',
                    'body' => 'El agua que cae del cielo no limpia nada; sólo arrastra los residuos químicos de las chimeneas de la zona industrial. Si Miller no entrega los códigos de desbloqueo antes del amanecer, la red neuronal colapsará por completo.',
                    'tags' => ['Peligro', 'Plazo Crítico', 'Distrito 4'],
                ],
            ]
        );

        // 7. Connections
        CanvasConnection::query()->firstOrCreate(
            ['board_id' => $board->id, 'source_node_id' => $node1->id, 'target_node_id' => $node2->id],
            [
                'label' => 'Investiga aquí',
                'badge_icon' => 'radar',
                'curvature' => 'curved',
                'color' => '#4F46E5',
            ]
        );

        // 8. Library Items
        LibraryItem::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Compendio de Inteligencia: Proyecto Ocular Mk.IV'],
            [
                'category' => 'Lore & Documentos',
                'author' => 'Dra. Valeria Ruiz',
                'content' => 'Análisis exhaustivo del implante óptico militar Mk.IV. Posee capacidad de visualización termográfica, detección de firmas EM y grabación involuntaria de recuerdos biométricos encriptados.',
                'tags' => ['Cibernética', 'Confidencial', 'Distrito 4', 'Implantes'],
                'file_type' => 'dossier',
            ]
        );

        LibraryItem::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Tratado de No Proliferación de IAs Autónomas (2089)'],
            [
                'category' => 'Leyes & Manuscritos',
                'author' => 'Consejo Supremo de Neo-Kyoto',
                'content' => 'Acuerdo multilateral firmado tras la crisis del Protocolo Quimera, limitando la densidad de cálculo de entidades sintéticas en redes comerciales.',
                'tags' => ['Normativa', 'Historia', 'IA'],
                'file_type' => 'legal',
            ]
        );

        LibraryItem::query()->firstOrCreate(
            ['universe_id' => $universe->id, 'title' => 'Frecuencias de Radio de los Bajos Fondos'],
            [
                'category' => 'Señales & Audio',
                'author' => 'Soran Kurogane',
                'content' => 'Registro de señales de radio de onda corta usadas por transportistas y contrabandistas en el sector portuario.',
                'tags' => ['Radio', 'Frecuencias', 'Clandestino'],
                'file_type' => 'intel',
            ]
        );
    }
}
