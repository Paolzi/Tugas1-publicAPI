pipeline {
    agent any

    stages {
        stage('Checkout SCM') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                // Menggunakan --network=host agar container build memakai DNS host Windows
                bat 'docker build --network=host -t syaidan/tugas1-publicapi:latest .'
            }
        }

        stage('Push Docker Image') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    bat 'echo %DOCKER_PASS% | docker login -u %DOCKER_USER% --password-stdin'
                    bat 'docker push syaidan/tugas1-publicapi:latest'
                }
            }
        }
    }
}
