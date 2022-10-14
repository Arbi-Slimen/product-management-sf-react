import Cart from "./Product";
import React, {useState, useEffect} from "react";
import Page from "./Page";
import {Loader} from "./Loader";
import {useFetch} from "../api/api";
import Product from "./Product";

function ListProduct() {

    const [page, updatePage] = useState(1)
    const [productName, updateProductName] = useState('');
    const [category, updateCategory] = useState('');
    const [price, updatePrice] = useState(0);
    const limit = 12

    const {
        data,
        isLoading,
        error
    } = useFetch(`http://127.0.0.1:8000/api/products?page=${page}&limit=${limit}&productName=${productName}&category=${category}&price=${price}`, [page, limit, productName, category, price])

    if (error) {
        return <span style={{display: 'flex', justifyContent: 'center'}}>Oups problème de fetch</span>
    }

    return (
        <div>
            {isLoading ? (<Loader/>) :
                <section className="py-5">
                    <div className="container px-4 px-lg-5 mt-5">
                        <div className="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                            {data['products'].map((product, index) => (
                                <Product
                                    key={`product-${product.id}`}
                                    productName={product.productName}
                                    price={product.price}
                                    imageUrl={product.imageUrl}
                                    averageScore={product.averageScore}
                                    category={product.category.category}
                                    id={product.id}>
                                </Product>
                            ))}
                        </div>
                    </div>
                </section>
            }
            <div style={{display: 'flex', justifyContent: 'center'}}>
                <Page
                    totalItemsCount={data.countProducts}
                    page={page}
                    updatePage={updatePage}
                    limit={limit}
                />
            </div>
        </div>
    )
}

export default ListProduct