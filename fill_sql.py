#!/usr/bin/env python3

import os
import re
import mysql.connector as mysql
from mutagen.mp3 import MP3

con = mysql.connect(user="root", password="", host="localhost", database="slotify")
cursor = con.cursor()

img_extensions = [".jpg", ".png", ".JPG", "jpeg", "JPEG", ".gif"]
audio_extensions = [".mp3", ".MP3"]

path = "/opt/lampp/htdocs/ebweb/WebDev/slotify/Music"

g, art, alb, track_nr = 1, 1, 1, 1
genre_list = []
artists_list = []
album_list = []
songs_list = []
genres = sorted(os.listdir(path))

for genre in genres:
    if not genre.startswith("."):
        if genre == "Folk":
            continue
        image_path = f"assets/images/genres/{genre.lower()}.jpg"
        cursor.execute(f"INSERT INTO genres VALUES(NULL, '{genre}', '{image_path}')")
        genre_list.append(genre)
        artists_path = path + "/" + genre
        artists = os.listdir(artists_path)
        for artist in artists:
            if not artist.startswith("."):
                albums_path = artists_path + "/" + artist
                albums = sorted(os.listdir(albums_path))
                current_albums = len(album_list)
                for album in albums:
                    songs_path = albums_path + "/" + album
                    songs = sorted(os.listdir(songs_path))
                    current = len(songs_list)
                    for song in songs:
                        if not song[-4:] in audio_extensions:
                            continue
                        else:
                            try:
                                duration_path = songs_path + "/" + song
                                audio = MP3(duration_path)
                                length = audio.info.length
                                m = str(int(length // 60))
                                s = str(round(length % 60))
                                if int(s) < 10:
                                    s = "0" + s
                                duration = m + "." + s
                            except:
                                duration = "0.00"
                                print(duration_path)

                            song_path = "Music/" + genre + "/" + artist + "/" + album + "/" + song
                            song_path = re.sub("'", "''", song_path)
                            song = re.sub("'", "''", song)
                            cursor.execute(f"INSERT songs VALUES(NULL, '{song[:-4]}', '{art}', '{alb}', '{g}', '{duration}', '{song_path}', '{track_nr}', '0')")
                            songs_list.append([g, art, alb, song[:-4], song_path, duration])
                            track_nr += 1
                    if len(songs_list) > current:
                        for song in songs:
                            if song[-4:] in img_extensions:
                                img_path = "Music/" + genre + "/" + artist + "/" + album + "/" + song
                                img_path = re.sub("'", "''", img_path)
                                break
                            else:
                                img_path = "assets/images/profile-pics/unknown.jpeg"
                        album = re.sub("'", "''", album)
                        cursor.execute(f"INSERT albums VALUES(NULL, '{album}', '{art}', '{g}', '{img_path}')")
                        album_list.append([g, art, alb, album])
                        alb += 1
                        track_nr = 1
                if len(album_list) > current_albums:
                    artist = re.sub("'", "''", artist)
                    cursor.execute(f"INSERT artists VALUES(NULL, '{g}', '{artist}')")
                    artists_list.append([g, art, artist])
                    art += 1
        g += 1
con.commit()
cursor.close()
con.close()

