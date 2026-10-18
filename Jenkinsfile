
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
                bat '''
                    docker version
                    docker build --network=host -t syaidan/tugas1-publicapi:latest .
                '''
            }
        }

        stage('Login Docker Hub') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'dockerhub-credentials',
                        usernameVariable: 'DOCKER_USER',
                        passwordVariable: 'DOCKER_PASS'
                    )
                ]) {
                    bat '''
                        @echo off
                        echo %DOCKER_PASS% | docker login -u %DOCKER_USER% --password-stdin
                    '''
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                bat 'docker push syaidan/tugas1-publicapi:latest'
            }
        }
    }

    post {
        success {
            echo 'Pipeline berhasil! Docker image sudah di-push ke Docker Hub.'
        }

        failure {
            echo 'Pipeline gagal. Periksa log pada stage yang berwarna merah.'
        }

        always {
            echo 'Pipeline selesai dijalankan.'
        }
    }
}
