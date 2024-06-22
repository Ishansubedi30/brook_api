import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import mysql.connector


# Function to fetch data from MySQL database
def fetch_books_from_database():
    # Connect to your MySQL database
    conn = mysql.connector.connect(
        host='127.0.0.1',
        user='root',
        password='',
        database='brook_db'
    )

    # Query to fetch data from the database
    query = "SELECT Title, Author, Genre, Publication_Year, Rating FROM books"

    # Execute the query and fetch all results
    cursor = conn.cursor()
    cursor.execute(query)
    books_data = cursor.fetchall()

    # Close cursor and connection
    cursor.close()
    conn.close()

    # Return fetched data as a pandas DataFrame
    columns = ['Title', 'Author', 'Genre', 'Publication_Year', 'Rating']
    return pd.DataFrame(books_data, columns=columns)


# Load data from MySQL database
books_df = fetch_books_from_database()

# Create a TF-IDF Vectorizer
tfidf_vectorizer = TfidfVectorizer(stop_words='english')

# Combine text columns into a single column
books_df['Features'] = books_df['Genre'] + ' ' + books_df['Author'] + ' ' + books_df['Publication_Year'].astype(
    str) + ' ' + books_df['Rating'].astype(str)

# Fit the TF-IDF Vectorizer and transform the data
tfidf_matrix = tfidf_vectorizer.fit_transform(books_df['Features'])

# Compute cosine similarity matrix
cosine_sim = cosine_similarity(tfidf_matrix, tfidf_matrix)


# Function to recommend books based on cosine similarity
def recommend_books(title, cosine_sim=cosine_sim, books_df=books_df, top_n=5):
    # Find the index of the book that matches the title
    idx = books_df.index[books_df['Title'] == title].tolist()[0]

    # Get pairwise similarity scores with all books
    sim_scores = list(enumerate(cosine_sim[idx]))

    # Sort the books based on the similarity scores
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

    # Get the scores of the top similar books
    sim_scores = sim_scores[1:top_n + 1]  # Exclude the first item (itself)

    # Get the book indices
    book_indices = [i[0] for i in sim_scores]

    # Return the titles of the top similar books
    return books_df['Title'].iloc[book_indices]


# Example usage
target_book = 'The Hunger Games'  # Replace with any book title from your dataset
recommended_books = recommend_books(target_book, top_n=5)  # Recommend 5 books

print(f"Recommended books for '{target_book}':")
print(recommended_books)
