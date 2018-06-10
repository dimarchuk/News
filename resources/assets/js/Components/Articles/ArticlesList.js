import React, {Component} from 'react';
import Axios from 'axios';

import {apiUrl} from "../../Helpers/index";

import Article from './Article';
import Pagination from '../Pagination/Pagination';
import Filter from '../Filter/Filter';

import './ArticlesList.css';

export default class ArticlesList extends Component {
    constructor() {
        super();

        this.state = {};
    }

    componentWillMount() {
        this.getArticles();
        // this.getToken();
        this.getFilters();
    }

    getArticles(page = 1) {
        Axios.get(`${apiUrl}articles?page=${page}`)
            .then(response => {
                this.setState({
                    articles: response.data
                });
            })
            .catch(error => console.log(error));
    }

    // getToken() {
    //     Axios.post(`${apiUrl}token`)
    //         .then(response => {
    //             // this.setState({
    //             //     articles: response.data
    //             // });
    //             console.log(response);
    //         })
    //         .catch(error => console.log(error));
    // }

    setFilters(data = {categoriesId: [1], tagsId: [1], dateFrom: '2010-06-08', dateTo: '2018-06-08'}) {
        Axios({
            url:`${apiUrl}search`,
            method: 'POST',
            data: data,
            headers: {
                'Content-type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            }

        })
            .then(response => {
                this.setState({
                    articles: response.data
                });
            })
            .catch(error => console.log(error.response));
    }

    getFilters() {
        Axios.get(`${apiUrl}search`)
            .then(response => {
                this.setState({
                    filters: response.data
                });
            })
            .catch(error => console.log(error))
    }

    render() {
        const articles = this.state.articles;
        const filters = this.state.filters;

        if (articles) {
            return (
                <div className="articles-list">
                    {
                        filters ? (
                            <div className="article__filter">
                                <Filter filters={filters} callback={this.setFilters.bind(this)} />
                            </div>
                        ) : (<p></p>)
                    }
                    {
                        articles.item.map(article => (
                            <Article key={article.id} article={{ title: article.name, id: article.id }} />
                        ))
                    }
                    {
                        this.state.articles.currentPage ? (
                            <div className="articles-list__pagination">
                                <Pagination activePage={articles.currentPage} pagination={articles.countPages}
                                            callback={this.getArticles.bind(this)}/>
                            </div>
                        ) : (<p></p>)
                    }
                </div>
            );
        } else {
            return (
                <div className="articles-list">
                    <span>Loading...</span>
                </div>
            );
        }

    }
}