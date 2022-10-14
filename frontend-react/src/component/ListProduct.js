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

    function handleChange() {
        updatePage(1)
        updateProductName(document.form.product_name.value)
        updateCategory(document.form.category.value)
        updatePrice(document.form.price.value)
    }

    function handleClear() {
        updateProductName('')
        updateCategory('')
        updatePrice(0)
    }


    return (
        <div>
            {isLoading ? (<Loader/>) :
                <section className="py-5">
                    <div className="container px-4 px-lg-5 mt-5">
                        <form name="form">
                            <div className="form-group">
                                <label>Product name</label>
                                <input type="text" name='product_name' className="form-control"
                                       defaultValue={productName}/>
                            </div>
                            <div className="form-group">
                                <label>Category</label>
                                <select className="form-control" name='category' defaultValue={category}>
                                    <option></option>
                                    <option>Awesome</option>
                                    <option>Ergonomic</option>
                                    <option>Fantastic</option>
                                    <option>Generic</option>
                                    <option>Gorgeous</option>
                                    <option>Handcrafted</option>
                                    <option>Handmade</option>
                                    <option>Incredible</option>
                                    <option>Intelligent</option>
                                    <option>Licensed</option>
                                    <option>Practical</option>
                                    <option>Refined</option>
                                    <option>Rustic</option>
                                    <option>Sleek</option>
                                    <option>Small</option>
                                    <option>Tasty</option>
                                    <option>Unbranded</option>
                                </select>
                            </div>
                            <div className="form-group">
                                <label>Price</label><span className="help-block">price higher than the input.</span>
                                <input type="number" name='price' defaultValue={price} className="form-control"
                                       min='0'/>
                            </div>
                            <div className="form-group">
                                <input type="button" value="Filters" className="btn btn-primary"
                                       onClick={() => handleChange()}/> <input type="button" value="Clear"
                                                                               className="btn btn-primary"
                                                                               onClick={() => handleClear()}/> Totals: {data.countProducts}
                            </div>

                        </form>
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