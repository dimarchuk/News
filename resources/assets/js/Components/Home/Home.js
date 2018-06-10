import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Axios from 'axios';

import './Home.css';

import { apiUrl } from '../../Helpers/index';

import Category from '../Articles/Category';
import Slider from '../Slider/Slider';

export default class Home extends Component {
    constructor() {
        super();
        this.state = {};
    }

    componentWillMount() {
        Axios.get(`${apiUrl}index`)
            .then(response => {
                this.setState({
                    articles: response.data.articles,
                    slider: response.data.sliderInfo
                });
            })
            .catch(error => console.log(error));

        Axios({
            url: `${apiUrl}active`,
            method: 'GET',
            mode: 'no-cors',
            headers: {
                'Content-type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            }
        })
            .then(response => {
                this.setState({
                    activeUsers: response.data.topUsers,
                    topArticles: response.data.topArticles
                });
            })
            .catch(error => console.log(error));
    }

    render() {
        let Slired;
        let CategoryElements;
        let TopUsers;
        let TopThemes;

        if (this.state.slider) {
            Slired = <Slider slides={this.state.slider} />
        }

        if (this.state.articles) {
            CategoryElements = this.state.articles.map((category, index) => (
                <Category key={index} article={category} />
            ));
        }

        if (this.state.activeUsers) {
            TopUsers = this.state.activeUsers.map(user => (
                <div key={user.user_id} className="top-user" >
                    <span>Пользоваетль: <Link to={`/userinfo/${user.user_id}`}>{user.email}</Link></span>
                    <span>Количество комментариев: {user.count}</span>
                </div>
            ));
        }

        if (this.state.topArticles) {
            TopThemes = this.state.topArticles.map(article => (
                <div key={article.news_id} className="top-theme" >
                    <Link to={`/article/${article.news_id}`}>{article.title}</Link>
                    <span>Количество комментариев: {article.count}</span>
                </div>
            ));
        }


        return (
            <div className='Home'>
                <div className="home__category">
                    {CategoryElements}
                </div>
                <div className="home__slider">
                    {Slired}
                </div>
                <div className="home__top-users">
                    <div className="home__title">
                        <span>Самые активные пользователи</span>
                    </div>
                    {TopUsers}
                </div>
                <div className="home__top-themes">
                    <div className="home__title">
                        <span>Самые популярные статьи</span>
                    </div>
                    {TopThemes}
                </div>
            </div>
        )
    }
}