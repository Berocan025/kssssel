#!/usr/bin/env python3
"""
SQLite Veritabanı Analiz Scripti
Blog yazılarının nasıl geldiğini anlayalım
"""

import sqlite3
import os

def analyze_database():
    db_path = "database/portfolio.db"
    
    print("📊 VERİTABANI İÇERİK ANALİZİ")
    print("=" * 50)
    
    if not os.path.exists(db_path):
        print(f"❌ Database dosyası bulunamadı: {db_path}")
        return
    
    print(f"✅ Database dosyası bulundu: {db_path}")
    print(f"📁 Dosya boyutu: {os.path.getsize(db_path)} bytes")
    print()
    
    try:
        conn = sqlite3.connect(db_path)
        cursor = conn.cursor()
        
        # 1. Mevcut tabloları listele
        print("1. MEVCUT TABLOLAR")
        print("-" * 30)
        cursor.execute("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")
        tables = cursor.fetchall()
        
        for (table_name,) in tables:
            print(f"📋 {table_name}")
            
            # Tablo yapısını göster
            cursor.execute(f"PRAGMA table_info({table_name})")
            columns = cursor.fetchall()
            
            print("  Kolonlar:")
            for col in columns:
                col_name, col_type, not_null, default, pk = col[1], col[2], col[3], col[4], col[5]
                print(f"    - {col_name} ({col_type})" + (" PRIMARY KEY" if pk else ""))
            
            # Kayıt sayısı
            cursor.execute(f"SELECT COUNT(*) FROM {table_name}")
            count = cursor.fetchone()[0]
            print(f"  📊 Kayıt sayısı: {count}")
            
            # Eğer az sayıda kayıt varsa içeriği göster
            if 0 < count < 20:
                print("  📄 İçerik örnekleri:")
                cursor.execute(f"SELECT * FROM {table_name} LIMIT 5")
                rows = cursor.fetchall()
                for i, row in enumerate(rows):
                    print(f"    [{i+1}] {row}")
            
            print()
        
        # 2. Blog yazıları özel analiz
        print("2. BLOG YAZILARI ANALİZİ")
        print("-" * 30)
        try:
            cursor.execute("SELECT id, title, status, created_at FROM blog_posts LIMIT 10")
            blog_posts = cursor.fetchall()
            
            if blog_posts:
                print("✅ Blog yazıları mevcut:")
                for post in blog_posts:
                    print(f"  - ID: {post[0]}, Başlık: {post[1]}, Status: {post[2]}, Tarih: {post[3]}")
            else:
                print("❌ Blog yazısı bulunamadı")
        except Exception as e:
            print(f"❌ Blog tablosu hatası: {e}")
        
        print()
        
        # 3. Projects analiz
        print("3. PROJELER ANALİZİ")
        print("-" * 30)
        try:
            # Önce projects tablosunun yapısını kontrol et
            cursor.execute("PRAGMA table_info(projects)")
            project_columns = cursor.fetchall()
            
            print("Projects tablosu kolonları:")
            for col in project_columns:
                print(f"  - {col[1]} ({col[2]})")
            
            # Veri kontrolü
            cursor.execute("SELECT COUNT(*) FROM projects")
            project_count = cursor.fetchone()[0]
            print(f"Mevcut proje sayısı: {project_count}")
            
            if project_count > 0:
                cursor.execute("SELECT * FROM projects LIMIT 3")
                projects = cursor.fetchall()
                print("Örnek projeler:")
                for project in projects:
                    print(f"  - {project}")
            
        except Exception as e:
            print(f"❌ Projects tablosu hatası: {e}")
        
        print()
        
        # 4. Products analiz
        print("4. ÜRÜNLER ANALİZİ")
        print("-" * 30)
        try:
            cursor.execute("SELECT COUNT(*) FROM products")
            product_count = cursor.fetchone()[0]
            print(f"Mevcut ürün sayısı: {product_count}")
            
            if product_count > 0:
                cursor.execute("SELECT id, title, price FROM products LIMIT 3")
                products = cursor.fetchall()
                print("Örnek ürünler:")
                for product in products:
                    print(f"  - ID: {product[0]}, Başlık: {product[1]}, Fiyat: {product[2]}")
            
        except Exception as e:
            print(f"❌ Products tablosu hatası: {e}")
        
        print()
        
        # 5. Settings analiz
        print("5. AYARLAR ANALİZİ")
        print("-" * 30)
        try:
            cursor.execute("SELECT setting_key, setting_value FROM settings")
            settings = cursor.fetchall()
            
            if settings:
                print("Mevcut ayarlar:")
                for setting in settings:
                    print(f"  - {setting[0]} = {setting[1]}")
            else:
                print("❌ Ayar bulunamadı")
                
        except Exception as e:
            print(f"❌ Settings tablosu hatası: {e}")
        
        conn.close()
        
    except Exception as e:
        print(f"❌ Veritabanı bağlantı hatası: {e}")

if __name__ == "__main__":
    analyze_database()