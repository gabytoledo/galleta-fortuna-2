-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2026 a las 09:00:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `galleta_fortuna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_galletas`
--

CREATE TABLE `historial_galletas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensaje_id` int(11) NOT NULL,
  `fecha_apertura` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_galletas`
--

INSERT INTO `historial_galletas` (`id`, `usuario_id`, `mensaje_id`, `fecha_apertura`) VALUES
(1, 1, 96, '2026-06-19 03:16:12'),
(2, 1, 103, '2026-06-19 03:16:21'),
(3, 1, 78, '2026-06-19 03:16:24'),
(4, 1, 70, '2026-06-19 03:16:26'),
(5, 1, 94, '2026-06-19 03:16:29'),
(6, 1, 30, '2026-06-19 03:16:29'),
(7, 1, 86, '2026-06-19 03:16:30'),
(8, 1, 102, '2026-06-19 03:16:30'),
(9, 1, 18, '2026-06-19 03:16:31'),
(10, 4, 11, '2026-06-19 03:22:44'),
(11, 4, 89, '2026-06-19 03:22:46'),
(12, 4, 68, '2026-06-19 03:25:34'),
(13, 4, 25, '2026-06-19 03:25:35'),
(14, 4, 69, '2026-06-19 03:25:36'),
(15, 4, 94, '2026-06-19 03:25:36'),
(16, 4, 102, '2026-06-19 03:25:37'),
(17, 4, 60, '2026-06-19 03:38:03'),
(18, 4, 72, '2026-06-19 03:38:05'),
(19, 4, 59, '2026-06-19 03:38:05'),
(20, 4, 113, '2026-06-19 03:38:05'),
(21, 4, 84, '2026-06-19 03:38:06'),
(22, 4, 43, '2026-06-19 03:38:06'),
(23, 4, 55, '2026-06-19 03:38:19'),
(24, 4, 83, '2026-06-19 03:38:20'),
(25, 4, 52, '2026-06-19 03:38:20'),
(26, 4, 99, '2026-06-19 03:46:36'),
(27, 4, 45, '2026-06-19 03:48:31'),
(28, 4, 62, '2026-06-19 03:48:33'),
(29, 4, 19, '2026-06-19 03:48:36'),
(30, 4, 32, '2026-06-19 03:48:40'),
(31, 1, 13, '2026-06-19 03:58:14'),
(32, 1, 42, '2026-06-19 03:58:17'),
(33, 1, 30, '2026-06-19 03:58:18'),
(34, 1, 16, '2026-06-19 03:58:19'),
(35, 1, 42, '2026-06-19 03:59:31'),
(36, 1, 106, '2026-06-19 03:59:33'),
(37, 1, 40, '2026-06-19 03:59:35'),
(38, 4, 51, '2026-06-19 03:59:47'),
(39, 4, 110, '2026-06-19 03:59:49'),
(40, 1, 70, '2026-06-19 04:00:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `texto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `texto`) VALUES
(1, 'La paciencia es la llave que abre las puertas del destino.'),
(2, 'Un pequeño paso hoy puede convertirse en un gran camino mañana.'),
(3, 'La sabiduría llega a quien aprende de sus errores.'),
(4, 'No temas avanzar lento, teme quedarte quieto.'),
(5, 'Tu esfuerzo silencioso pronto dará frutos.'),
(6, 'La fortuna sonríe a quien se atreve a intentarlo.'),
(7, 'Cada final es el inicio de una nueva oportunidad.'),
(8, 'El camino correcto no siempre es el más fácil.'),
(10, 'si te pasas de verde, jugo de naranja ifyk yk'),
(11, 'No todo bug es enemigo, a veces es un tutorial disfrazado.'),
(12, 'El verdadero gamer no pierde, descubre rutas alternativas al fracaso.'),
(13, 'Tu próxima partida puede ser la que cambie todo.'),
(14, 'Si el jefe final parece imposible, farmeá experiencia y volvé más fuerte.'),
(15, 'La paciencia es el mejor buff del jugador sabio.'),
(16, 'No ragequitees: hasta las derrotas dan experiencia.'),
(17, 'Hoy tu inventario se llenará de oportunidades.'),
(18, 'El lag pasa, la gloria queda.'),
(19, 'Todo héroe empezó con equipo básico.'),
(20, 'No subestimes una build rara: puede romper el meta.'),
(21, 'El camino difícil suele tener el mejor loot.'),
(22, 'Guardar partida también es sabiduría.'),
(23, 'El NPC más importante de tu historia podés ser vos mismo.'),
(24, 'No todos los cofres brillan, pero todos enseñan algo.'),
(25, 'A veces perder una vida evita perder la partida.'),
(26, 'El verdadero crítico está en saber cuándo esquivar.'),
(27, 'Tu destino necesita menos miedo y más XP.'),
(28, 'Si el mapa no aparece, explorá igual.'),
(29, 'El grind de hoy es el poder de mañana.'),
(30, 'Un buen party se arma con confianza, no solo con nivel.'),
(31, 'No estás atascado, estás en una misión secundaria larga.'),
(32, 'Cada error de compilación es un minijefe.'),
(33, 'El mejor combo empieza con un primer botón.'),
(34, 'Hoy puede aparecer un drop legendario inesperado.'),
(35, 'No todos los enemigos merecen tu energía.'),
(36, 'La mejor skin es la confianza.'),
(37, 'Aunque estés en modo difícil, seguís jugando.'),
(38, 'Tu historia todavía no llegó al endgame.'),
(39, 'Un respawn también es una segunda oportunidad.'),
(40, 'No confundas pausa con derrota.'),
(41, 'Hasta el héroe más fuerte necesita pociones.'),
(42, 'El joystick no gana solo: la mente también juega.'),
(43, 'Tu build se está formando, no la abandones temprano.'),
(44, 'El tutorial puede ser largo, pero prepara para la aventura.'),
(45, 'A veces hay que cambiar de estrategia, no de sueño.'),
(46, 'El RNG favorece a quien sigue intentando.'),
(47, 'No todo nerf es castigo, a veces balancea tu camino.'),
(48, 'El boss más difícil suele estar antes del mejor capítulo.'),
(49, 'Tu progreso no se borra por una mala partida.'),
(50, 'Hoy sumás experiencia aunque no veas subir la barra.'),
(51, 'El jugador sabio sabe cuándo atacar y cuándo curarse.'),
(52, 'No vendas tus sueños por monedas comunes.'),
(53, 'El verdadero poder está en aprender los patrones.'),
(54, 'Si fallaste el salto, recalculá y volvé a intentar.'),
(55, 'La vida también tiene checkpoints invisibles.'),
(56, 'No todo camino oculto aparece en la primera vuelta.'),
(57, 'Tu party ideal llegará cuando avances de zona.'),
(58, 'El loot más valioso es la disciplina.'),
(59, 'La derrota solo es permanente si cerrás el juego.'),
(60, 'Todo personaje roto tuvo una fase débil.'),
(61, 'No estás bajo de nivel, estás en pleno farmeo.'),
(62, 'Hoy desbloqueás una nueva habilidad interna.'),
(63, 'Tu misión principal sigue activa.'),
(64, 'No dejes que un mal matchmaking defina tu valor.'),
(65, 'El silencio antes del boss fight también es parte de la aventura.'),
(66, 'Una buena estrategia vale más que mil golpes desesperados.'),
(67, 'Cuando el mapa se oscurece, empieza la exploración real.'),
(68, 'El crítico de la vida llega cuando menos lo esperás.'),
(69, 'Seguí jugando: todavía quedan cinemáticas hermosas.'),
(70, 'A veces el mejor movimiento es esperar el cooldown.'),
(71, 'No todo jugador solitario está solo: algunos están leveleando.'),
(72, 'Tu corazón también necesita mantenimiento de equipo.'),
(73, 'El modo historia no se termina en el primer acto.'),
(74, 'Un inventario desordenado también puede tener tesoros.'),
(75, 'Hoy esquivá toxicidad como si fuera daño de área.'),
(76, 'El verdadero pro no humilla novatos, los guía.'),
(77, 'Cada partida perdida mejora tu lectura del juego.'),
(78, 'No estás bugueado, estás en desarrollo.'),
(79, 'La actualización más importante es la que hacés en vos.'),
(80, 'No todos los logros aparecen en pantalla.'),
(81, 'La constancia es el cheat code permitido.'),
(82, 'Si caés en lava, aprendé dónde no pisar.'),
(83, 'El mejor equipo se consigue jugando, no esperando.'),
(84, 'Tu quest parece larga porque la recompensa es grande.'),
(85, 'No te compares con speedrunners: vos estás en tu primera run.'),
(86, 'A veces el camino casual enseña más que el competitivo.'),
(87, 'El boss final no se vence con ansiedad, se vence con patrón.'),
(88, 'Tu respawn emocional también cuenta.'),
(89, 'No abandones la build antes de ver su late game.'),
(90, 'El daño recibido también revela tu armadura.'),
(91, 'Cuando todo falla, revisá la configuración.'),
(92, 'El héroe no nace legendario: se vuelve legendario jugando.'),
(93, 'Tu save actual todavía tiene mucho potencial.'),
(94, 'No gastes maná en enemigos que no dan XP.'),
(95, 'El minimapa no muestra todo lo importante.'),
(96, 'La mejor party empieza con alguien que no se rinde.'),
(97, 'El fracaso es solo una pantalla de carga más larga.'),
(98, 'No todo bug se arregla rápido, pero todo bug enseña.'),
(99, 'Hoy podés desbloquear una ruta que ayer no veías.'),
(100, 'Los mejores finales requieren decisiones difíciles.'),
(101, 'El jugador paciente encuentra secretos que otros pasan de largo.'),
(102, 'Tu nivel real no siempre se ve en la interfaz.'),
(103, 'No estás perdiendo tiempo, estás cargando recursos.'),
(104, 'El modo difícil también da más experiencia.'),
(105, 'Cada intento suma precisión.'),
(106, 'No necesitás hacks: necesitás práctica y descanso.'),
(107, 'Tu próxima mejora puede estar a una misión de distancia.'),
(108, 'El verdadero loot fue la experiencia que ganaste en el camino.'),
(109, 'Incluso los NPCs secundarios pueden cambiar la historia.'),
(110, 'La victoria sabe mejor después de muchos intentos.'),
(111, 'Seguí farmeando: tu versión legendaria todavía se está crafteando.'),
(112, 'hgghg'),
(113, 'fdsfdsf'),
(115, 'aguante pragmata');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'gabriel', 'lookintoledo@gmail.com', '$2y$10$YHR1MtpVneaBuRTfYWHi.u07ksTVqZ.eePainEaDLkxi4mw4Pw5tC', 'admin'),
(2, 'pedro', 'lookintoledoooo@gmail.com', '$2y$10$0gyjo/Bf.Jf.ChYaVbD.bu8SFGndeX6CqQAB/qez8JmSaOYuCu1dO', 'usuario'),
(3, 'peruano', 'peruano@gmail.com', '$2y$10$Y.sPg8LxYQr5yXb3tgyzT.v6N.WgReqCQRnZjB5RdL.fHq1tKyDo6', 'admin'),
(4, 'jonny', 'jonnytelasaco@gmail.com', '$2y$10$6rPEsWK6Y24mtmRDNi76E.32QG0YVEYnCDswRibb330Fje8IVBp9q', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_galletas`
--
ALTER TABLE `historial_galletas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `mensaje_id` (`mensaje_id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_galletas`
--
ALTER TABLE `historial_galletas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_galletas`
--
ALTER TABLE `historial_galletas`
  ADD CONSTRAINT `historial_galletas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `historial_galletas_ibfk_2` FOREIGN KEY (`mensaje_id`) REFERENCES `mensajes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
